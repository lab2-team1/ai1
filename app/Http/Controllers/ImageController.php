<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * Upload images for a listing
     */
    public function upload(Request $request, Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('listings/' . $listing->id, 'public');

            $listingImage = ListingImage::create([
                'listing_id' => $listing->id,
                'image_url' => $path
            ]);

            $uploadedImages[] = $listingImage;
        }

        return response()->json([
            'message' => 'Images uploaded successfully',
            'images' => $uploadedImages
        ]);
    }

    /**
     * Delete an image
     */
    public function destroy(ListingImage $image)
    {
        if ($image->listing->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->image_url);

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

    /**
     * Get all images for a listing
     */
    public function index(Listing $listing)
    {
        $images = $listing->images;
        return response()->json(['images' => $images]);
    }
}
