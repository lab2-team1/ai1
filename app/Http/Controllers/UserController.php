<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        $listings = $user->listings()->active()->latest()->get(); // zakładam relację listings w modelu User
        return view('users.show', compact('user', 'listings'));
    }
}
