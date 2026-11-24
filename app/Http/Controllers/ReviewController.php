<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewCategory;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        $categories = ReviewCategory::orderBy('id')->get();
        return view('review.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'               => 'nullable|string|max:100',
            'rating'             => 'required|integer|between:1,5',
            'review_category_id' => 'required|exists:review_categories,id',
            'isi'                => 'required|string|min:10|max:2000',
            'website'            => 'prohibited', // honeypot anti-bot
        ], [
            'rating.required'  => 'Pilih rating bintang dulu ya.',
            'isi.required'     => 'Kritik dan saran wajib diisi.',
            'isi.min'          => 'Kritik dan saran minimal 10 karakter.',
        ]);

        unset($data['website']);

        $review = Review::create($data);

        return redirect()
            ->route('review.success')
            ->with('kode_ulasan', $review->kode_ulasan);
    }

    public function success()
    {
        if (! session()->has('kode_ulasan')) {
            return redirect()->route('review.create');
        }

        return view('review.success', ['kode' => session('kode_ulasan')]);
    }

    public function history(Request $request)
    {
        $kode = strtoupper(trim($request->query('kode', '')));
        $review = null;

        if ($kode !== '') {
            $review = Review::with(['category', 'reply'])
                ->where('kode_ulasan', $kode)
                ->first();
        }

        return view('review.history', compact('kode', 'review'));
    }
}
