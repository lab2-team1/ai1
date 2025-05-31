<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $addresses = $user ? $user->addresses : new Collection();

        return view('dashboards.userDashboard', compact('user', 'addresses'));
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
        return view('users.show', compact('user', 'listings'));
    }

    /**
     * Aktualizuj dane użytkownika.
     */
    public function update(Request $request)
    {
        Log::info('Received update request', $request->all());
        
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
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
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
}
