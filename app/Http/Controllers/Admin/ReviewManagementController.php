<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['category', 'reply'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->q;
                $query->where(function ($sub) use ($q) {
                    $sub->where('isi', 'like', "%{$q}%")
                        ->orWhere('nama', 'like', "%{$q}%")
                        ->orWhere('kode_ulasan', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('rating'), fn ($query) => $query->where('rating', $request->rating))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('dari'), fn ($query) => $query->whereDate('created_at', '>=', $request->dari))
            ->when($request->filled('sampai'), fn ($query) => $query->whereDate('created_at', '<=', $request->sampai))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'         => Review::count(),
            'belum_dibalas' => Review::where('status', 'belum_dibalas')->count(),
            'rata_rata'     => round(Review::avg('rating') ?? 0, 1),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    public function show(Review $review)
    {
        $review->load(['category', 'reply']);
        return view('admin.reviews.show', compact('review'));
    }

    public function reply(Request $request, Review $review)
    {
        $data = $request->validate([
            'balasan' => 'required|string|min:3|max:1000',
        ]);

        ReviewReply::updateOrCreate(
            ['review_id' => $review->id],
            ['user_id' => $request->user()->id, 'balasan' => $data['balasan']]
        );

        // ulasan yang sengaja disembunyikan tetap disembunyikan
        if ($review->status !== 'disembunyikan') {
            $review->update(['status' => 'sudah_dibalas']);
        }

        return back()->with('sukses', 'Balasan berhasil disimpan.');
    }

    public function updateStatus(Request $request, Review $review)
    {
        $data = $request->validate([
            'status' => 'required|in:belum_dibalas,sudah_dibalas,disembunyikan',
        ]);

        $review->update($data);

        return back()->with('sukses', 'Status ulasan diperbarui.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('sukses', 'Ulasan dihapus.');
    }
}
