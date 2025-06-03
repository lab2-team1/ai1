<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\UserRating;
use Illuminate\Support\Facades\Auth;

class UserRatingController extends Controller
{
    public function create($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        return view('users\userRatings\create', compact('transaction'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rated_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        UserRating::create([
            'transaction_id' => $validated['transaction_id'],
            'rated_user_id' => $validated['rated_user_id'],
            'rated_by_user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ocena została dodana!');
    }
}
