<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $images = $listing->images()->orderBy('order')->get();
        return response()->json(['images' => $images]);
    }

    /**
     * Set an image as primary
     */
    public function setPrimary(ListingImage $image)
    {
        if ($image->listing->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Remove primary status from all other images
        $image->listing->images()->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        return response()->json(['message' => 'Primary image updated successfully']);
    }

    /**
     * Reorder images
     */
    public function reorder(Request $request, Listing $listing)
    {
        \Log::info('Starting image reorder', [
            'listing_id' => $listing->id,
            'request_data' => $request->all()
        ]);

        if ($listing->user_id !== Auth::id()) {
            \Log::warning('Unauthorized reorder attempt', [
                'listing_id' => $listing->id,
                'user_id' => Auth::id()
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:listing_images,id'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Start a database transaction
        DB::beginTransaction();
        try {
            foreach ($request->image_ids as $order => $imageId) {
                \Log::info('Updating image order', [
                    'image_id' => $imageId,
                    'order' => $order
                ]);

                $updated = ListingImage::where('id', $imageId)
                    ->where('listing_id', $listing->id)
                    ->update(['order' => $order]);

                \Log::info('Update result', [
                    'image_id' => $imageId,
                    'updated' => $updated
                ]);
            }
            DB::commit();
            \Log::info('Reorder completed successfully');
            return response()->json(['message' => 'Images reordered successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to reorder images', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to reorder images: ' . $e->getMessage()], 500);
        }
    }
}
