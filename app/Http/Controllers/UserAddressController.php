<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses;

        return view('user.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->addresses()->create($validated);

        return redirect()->route('user.dashboard')
            ->with('success', 'Address added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);

        $address->update($validated);

        return redirect()->route('user.dashboard')
            ->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('user.dashboard')
            ->with('success', 'Address deleted successfully.');
    }
}
