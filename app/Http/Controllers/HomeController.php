<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['user', 'category'])
            ->where('status', Listing::STATUS_ACTIVE)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::all();

        return view('index', compact('listings', 'categories'));
    }
}
