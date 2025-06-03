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

        // Sprawdź, czy użytkownik już ocenił tę transakcję
        $alreadyRated = \App\Models\UserRating::where('transaction_id', $validated['transaction_id'])
            ->where('rated_by_user_id', auth()->id())
            ->exists();

        if ($alreadyRated) {
            return redirect()->back()->withErrors(['rating' => 'Już wystawiłeś ocenę dla tej transakcji.']);
        }

        \App\Models\UserRating::create([
            'transaction_id' => $validated['transaction_id'],
            'rated_user_id' => $validated['rated_user_id'],
            'rated_by_user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('user.transactions')->with('success', 'Ocena została dodana!');
    }
}
