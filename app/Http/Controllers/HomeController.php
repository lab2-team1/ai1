<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['user', 'category'])
            ->where('status', Listing::STATUS_ACTIVE);

        // Najpierw promowane, potem reszta
        $query->orderByRaw('(promotion_expires_at IS NOT NULL AND promotion_expires_at > NOW()) DESC')
              ->orderByRaw('CASE WHEN promotion_expires_at IS NOT NULL AND promotion_expires_at > NOW() THEN promotion_expires_at ELSE NULL END DESC')
              ->latest();

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort filter
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date_desc':
                    $query->latest();
                    break;
                case 'date_asc':
                    $query->oldest();
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $listings = $query->simplePaginate(8)->withQueryString();
        $categories = Category::all();

        return view('index', [
            'listings' => $listings,
            'categories' => $categories
        ]);
    }
}
