<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->routeIs('user.listings.index')) {
            // Panel użytkownika: tylko własne ogłoszenia
            $user = Auth::user();
            $listings = Listing::where('user_id', $user->id)->with('category')->latest()->get();
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
        $categories = \App\Models\Category::all();
        if (request()->routeIs('user.listings.create')) {
            return view('listings.user_create', compact('categories'));
        }
        return view('listings.create', compact('categories'));
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
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $validated['user_id'] = Auth::id();
            $validated['status'] = 'active';

            $listing = \App\Models\Listing::create($validated);

            // Losowanie czasu promocji 1-48h
            $promotionHours = rand(1, 48);
            $listing->promotion_expires_at = now()->addHours($promotionHours);
            $listing->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('listings/' . $listing->id, 'public');
                    \App\Models\ListingImage::create([
                        'listing_id' => $listing->id,
                        'image_url' => $path
                    ]);
                }
            }

            return redirect()->route('user.listings.index')->with('success', 'Listing added successfully!');
        }
        // Admin
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', \App\Models\Listing::$statuses),
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $listing = \App\Models\Listing::create($validated);

        if ($request->hasFile('images')) {
            Log::info('Processing admin image uploads', ['count' => count($request->file('images'))]);
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings/' . $listing->id, 'public');
                Log::info('Image stored', ['path' => $path]);
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_url' => $path
                ]);
            }
        } else {
            Log::info('No images uploaded in admin store');
        }

        return redirect()->route('admin.listings.index')->with('success', 'Listing added successfully!');
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
        $listing = \App\Models\Listing::with('images')->findOrFail($id);
        $categories = \App\Models\Category::all();

        if (request()->routeIs('user.listings.edit')) {
            // Only own listing
            abort_unless($listing->user_id === Auth::id(), 403);
            return view('listings.user_edit', compact('listing', 'categories'));
        }
        return view('listings.edit', compact('listing', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        if (request()->routeIs('user.listings.update')) {
            abort_unless($listing->user_id === Auth::id(), 403);
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $listing->update($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('listings/' . $listing->id, 'public');
                    ListingImage::create([
                        'listing_id' => $listing->id,
                        'image_url' => $path
                    ]);
                }
            }

            return redirect()->route('user.listings.index')->with('success', 'Listing updated successfully!');
        }

        // Admin update
        Log::info('Starting admin update', ['listing_id' => $id]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', Listing::$statuses),
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        Log::info('Validation passed', ['validated' => $validated]);

        try {
            $listing->update($validated);
            Log::info('Listing updated successfully');

            if ($request->hasFile('images')) {
                Log::info('Processing admin image uploads', [
                    'count' => count($request->file('images')),
                    'listing_id' => $listing->id
                ]);

                foreach ($request->file('images') as $image) {
                    $path = $image->store('listings/' . $listing->id, 'public');
                    Log::info('Image stored', ['path' => $path]);

                    $imageModel = ListingImage::create([
                        'listing_id' => $listing->id,
                        'image_url' => $path
                    ]);
                    Log::info('Image record created', ['image_id' => $imageModel->id]);
                }
            } else {
                Log::info('No images uploaded in admin update');
            }

            return redirect()->route('admin.listings.edit', $listing)
                ->with('success', 'Listing updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating listing', [
                'error' => $e->getMessage(),
                'listing_id' => $id
            ]);
            return redirect()->back()
                ->with('error', 'An error occurred while updating the listing.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        if (request()->routeIs('user.listings.destroy')) {
            abort_unless($listing->user_id === \Illuminate\Support\Facades\Auth::id(), 403);
            $listing->delete();
            return redirect()->route('user.listings.index')->with('success', 'Listing has been deleted.');
        }
        $listing->delete();
        return redirect()->route('admin.listings.index')->with('success', 'Listing has been deleted.');
    }

    /**
     * Delete a listing image
     */
    public function deleteImage(ListingImage $image)
    {
        // Check if user is authorized to delete the image
        if (request()->routeIs('user.listings.delete-image')) {
            abort_unless($image->listing->user_id === Auth::id(), 403);
        }

        try {
            // Delete the file from storage
            Storage::disk('public')->delete($image->image_url);

            // Delete the image record from database
            $image->delete();

            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            }

            return redirect()->back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting image'], 500);
            }

            return redirect()->back()->with('error', 'Error deleting image');
        }
    }
}
