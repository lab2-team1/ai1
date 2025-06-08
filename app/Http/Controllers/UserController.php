<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use OTPHP\TOTP; // Dodane do obsługi OTP
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();


        $addresses = $user ? $user->addresses : new Collection();
        $transactionsKupione = $user ? $user->transactionsKupione()->with('listing', 'seller')->latest('transaction_date')->get() : collect();
        $transactionsSprzedane = $user ? $user->transactionsSprzedane()->with('listing', 'buyer')->latest('transaction_date')->get() : collect();



        return view('dashboards.userDashboard', compact('user', 'addresses', 'transactionsKupione', 'transactionsSprzedane'));
    }

    /**
     * Wyświetl listę użytkowników.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Wyświetl profil konkretnego użytkownika.
     */

    public function show($id)
    {
        $user = User::findOrFail($id);
        $listings = $user->listings()->active()->latest()->get();

        // DODAJ TO:
        $ratingsAsBuyer = \App\Models\UserRating::where('rated_user_id', $user->id)
            ->whereHas('transaction', function ($q) use ($user) {
                $q->where('buyer_id', $user->id);
            })
            ->with(['transaction.listing', 'rater'])
            ->latest()
            ->take(5)
            ->get();

        $ratingsAsSeller = \App\Models\UserRating::where('rated_user_id', $user->id)
            ->whereHas('transaction', function ($q) use ($user) {
                $q->where('seller_id', $user->id);
            })
            ->with(['transaction.listing', 'rater'])
            ->latest()
            ->take(5)
            ->get();

        return view('users.show', compact('user', 'listings', 'ratingsAsBuyer', 'ratingsAsSeller'));
    }

    /**
     * Aktualizuj dane użytkownika.
     */
    public function update(Request $request)
    {
        $safeFields = ['first_name', 'last_name', 'email', 'phone']; // Define safe fields to log
        Log::info('Received update request', $request->only($safeFields));

        $user = Auth::user();
        Log::info('Current user', ['user_id' => $user->id]);

        try {
            DB::beginTransaction();

            $messages = [
                'first_name.required' => 'The first name is required.',
                'first_name.string' => 'The first name must be a string.',
                'first_name.max' => 'The first name may not be greater than :max characters.',
                'last_name.required' => 'The last name is required.',
                'last_name.string' => 'The last name must be a string.',
                'last_name.max' => 'The last name may not be greater than :max characters.',
                'email.required' => 'The email address is required.',
                'email.string' => 'The email address must be a string.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'The email address may not be greater than :max characters.',
                'email.unique' => 'The email address has already been taken.',
                'phone.string' => 'The phone number must be a string.',
                'phone.max' => 'The phone number may not be greater than :max characters.',
            ];

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:255',
            ], $messages);

            Log::info('Data validated successfully', $validated);

            $hasChanges = false;
            foreach ($validated as $key => $value) {
                if (isset($user->$key) && $user->$key !== $value) {
                    if ($key === 'phone') {
                        if ($user->$key !== $value) {
                            $hasChanges = true;
                            break;
                        }
                    } else {
                        $hasChanges = true;
                        break;
                    }
                }
            }

            if (!$hasChanges) {
                Log::info('No changes to save');
                return redirect()->route('user.dashboard')
                    ->with('success', 'No changes were made.');
            }

            $updated = $user->update($validated);

            if (!$updated) {
                throw new \Exception('Failed to update user data.');
            }

            Log::info('Data updated successfully', ['user_id' => $user->id]);

            DB::commit();

            return redirect()->route('user.dashboard')
                ->with('success', 'Data updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating data: ' . $e->getMessage()]);
        }
    }


    /**
     * Show user transaction history.
     */
    public function transactions()
    {
        $user = Auth::user();
        $transactionsBought = $user ? $user->transactionsKupione()->with('listing', 'seller')->latest('transaction_date')->get() : collect();
        $transactionsSold = $user ? $user->transactionsSprzedane()->with('listing', 'buyer')->latest('transaction_date')->get() : collect();
        return view('dashboards.transactions', compact('transactionsBought', 'transactionsSold'));
    }

    public function show2faSetup()
    {
        $user = Auth::user();

        if (!$user->otp_secret) {
            $otp = TOTP::create();
            $user->otp_secret = $otp->getSecret();
            $user->save();
        }

        $otp = TOTP::createFromSecret($user->otp_secret);
        $otp->setLabel($user->email);

        // Generuj URL do kodu QR
        $renderer = new ImageRenderer(
            new RendererStyle(200), // Rozmiar obrazka
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd() // Użyj tego jeśli nie masz Imagick
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($otp->getProvisioningUri());

        // Zwróć obrazek jako URI danych
        $qrCodeUrl = 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);

        return view('auth.2fa', [
            'qrCodeUrl' => $qrCodeUrl,
            'secretKey' => $user->otp_secret
        ]);
    }

    public function enable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $user = Auth::user();
        $otp = TOTP::createFromSecret($user->otp_secret);

        if ($otp->verify($request->code)) {
            $user->two_factor_enabled = true;
            $user->save();

            return redirect()->route('user.2fa')
                ->with('success', 'Uwierzytelnianie dwuskładnikowe zostało włączone.');
        }

        return back()->withErrors(['code' => 'Nieprawidłowy kod weryfikacyjny.']);
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Nieprawidłowe hasło.']);
        }

        $user->two_factor_enabled = false;
        $user->otp_secret = null;
        $user->save();

        return redirect()->route('user.2fa')
            ->with('success', 'Uwierzytelnianie dwuskładnikowe zostało wyłączone.');
    }

    public function transactionStats()
    {
        $user = Auth::user();
        $transactionsBought = $user ? $user->transactionsKupione()->with('listing.category', 'seller')->latest('transaction_date')->get() : collect();
        $transactionsSold = $user ? $user->transactionsSprzedane()->with('listing.category', 'buyer')->latest('transaction_date')->get() : collect();
        return view('dashboards.transactionStats', compact('transactionsBought', 'transactionsSold'));
    }
}
