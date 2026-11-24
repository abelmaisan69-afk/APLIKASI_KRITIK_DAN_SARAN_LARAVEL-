<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featured = Product::with('category')->active()->featured()->latest()->take(4)->get();
        $promotions = Promotion::aktif()->orderBy('tanggal_berakhir')->take(3)->get();

        // Ulasan yang disembunyikan admin tidak ikut dihitung dan tidak tampil
        $total = Review::where('status', '!=', 'disembunyikan')->count();
        $avg = round(Review::where('status', '!=', 'disembunyikan')->avg('rating') ?? 0, 1);
        $dist = Review::where('status', '!=', 'disembunyikan')
            ->selectRaw('rating, COUNT(*) as jml')
            ->groupBy('rating')
            ->pluck('jml', 'rating');

        $reviews = Review::with(['category', 'reply'])
            ->where('status', '!=', 'disembunyikan')
            ->when($request->filled('rating'), fn ($q) => $q->where('rating', (int) $request->rating))
            ->latest()
            ->paginate(6)
            ->withQueryString()
            ->fragment('ulasan');

        return view('home', compact('featured', 'promotions', 'total', 'avg', 'dist', 'reviews'));
    }
}
