<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::with(['user', 'category'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', \App\Models\Listing::$statuses),
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        \App\Models\Listing::create($validated);

        return redirect()->route('admin.listings.index')->with('success', 'Ogłoszenie dodane!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', Listing::$statuses),
        ]);

        $listing->update($validated);

        return redirect()->route('admin.listings.edit', $listing)->with('success', 'Ogłoszenie zaktualizowane!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('admin.listings.index')->with('success', 'Ogłoszenie zostało usunięte.');
    }
}
