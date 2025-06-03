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
        if (request()->routeIs('user.listings.index')) {
            // Panel użytkownika: tylko własne ogłoszenia
            $user = auth()->user();
            $listings = $user->listings()->with('category')->latest()->get();
            return view('listings.user_index', compact('listings'));
        }
        // Admin/public: wszystkie ogłoszenia
        return view('listings.index', [
            'listings' => \App\Models\Listing::with(['user', 'category'])->get(),
            'categories' => \App\Models\Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->routeIs('user.listings.create')) {
            $categories = \App\Models\Category::all();
            return view('listings.user_create', compact('categories'));
        }
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (request()->routeIs('user.listings.store')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
            ]);
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'active';
            \App\Models\Listing::create($validated);
            return redirect()->route('user.listings.index')->with('success', 'Ogłoszenie dodane!');
        }
        // Admin
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
        $listing = Listing::with(['user', 'category'])->findOrFail($id);
        return view('listing', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        if (request()->routeIs('user.listings.edit')) {
            // Tylko własne ogłoszenie
            abort_unless($listing->user_id === auth()->id(), 403);
            $categories = \App\Models\Category::all();
            return view('listings.user_edit', compact('listing', 'categories'));
        }
        return view('listings.edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        if (request()->routeIs('user.listings.update')) {
            abort_unless($listing->user_id === auth()->id(), 403);
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
            ]);
            $listing->update($validated);
            return redirect()->route('user.listings.index')->with('success', 'Ogłoszenie zaktualizowane!');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', \App\Models\Listing::$statuses),
        ]);
        $listing->update($validated);
        return redirect()->route('admin.listings.edit', $listing)->with('success', 'Ogłoszenie zaktualizowane!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        if (request()->routeIs('user.listings.destroy')) {
            abort_unless($listing->user_id === auth()->id(), 403);
            $listing->delete();
            return redirect()->route('user.listings.index')->with('success', 'Ogłoszenie zostało usunięte.');
        }
        $listing->delete();
        return redirect()->route('admin.listings.index')->with('success', 'Ogłoszenie zostało usunięte.');
    }
}
