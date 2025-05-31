<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request, $listingId)
    {
        $listing = Listing::findOrFail($listingId);
        $user = Auth::user();

        if ($listing->user_id === $user->id) {
            return redirect()->back()->with('error', 'Nie możesz kupić własnego przedmiotu.');
        }
        if ($listing->status !== 'active') {
            return redirect()->back()->with('error', 'Przedmiot nie jest dostępny do kupna.');
        }

        $transaction = Transaction::create([
            'buyer_id' => $user->id,
            'seller_id' => $listing->user_id,
            'listing_id' => $listing->id,
            'amount' => $listing->price,
            'payment_method' => 'on delivery',
            'payment_status' => 'pending',
            'transaction_date' => now(),
        ]);

        $listing->markAsSold();

        return redirect()->route('payment.choose', ['transaction' => $transaction->id]);
    }

    public function choosePayment($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        return view('payment.choose', compact('transaction'));
    }

    public function processPayment(Request $request, $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $request->validate([
            'payment_method' => 'required|in:blik,bank_transfer,on_delivery',
        ]);
        $transaction->payment_method = $request->input('payment_method');
        $transaction->save();
        return redirect()->route('payment.confirmation', ['transaction' => $transaction->id]);
    }

    public function confirmation($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        return view('payment.confirmation', compact('transaction'));
    }
}
