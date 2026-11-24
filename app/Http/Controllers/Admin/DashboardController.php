<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => Review::count(),
            'rata'     => round(Review::avg('rating') ?? 0, 1),
            'lima'     => Review::where('rating', 5)->count(),
            'belum'    => Review::where('status', 'belum_dibalas')->count(),
        ];

        $dist = Review::selectRaw('rating, COUNT(*) as jml')
            ->groupBy('rating')
            ->pluck('jml', 'rating');

        // 6 bulan terakhir (jumlah + rata-rata rating per bulan)
        $mulai = now()->startOfMonth()->subMonths(5);
        $perBulan = Review::where('created_at', '>=', $mulai)
            ->get(['rating', 'created_at'])
            ->groupBy(fn ($r) => $r->created_at->format('Y-m'));

        $bulan = [];
        for ($i = 0; $i < 6; $i++) {
            $m = $mulai->copy()->addMonths($i);
            $grup = $perBulan->get($m->format('Y-m'), collect());

            $bulan[] = [
                'label'  => $m->translatedFormat('M'),
                'jumlah' => $grup->count(),
                'rata'   => $grup->count() ? round($grup->avg('rating'), 1) : 0,
            ];
        }
        $maxJumlah = max(1, collect($bulan)->max('jumlah'));

        $terbaru = Review::with('category')->latest()->take(5)->get();

        // aktivitas: ulasan masuk + balasan admin
        $aktivitas = collect();
        foreach (Review::latest()->take(5)->get() as $r) {
            $aktivitas->push([
                'waktu' => $r->created_at,
                'teks'  => 'Ulasan baru ' . $r->rating . '★ dari ' . ($r->nama ?: 'Anonim'),
            ]);
        }
        foreach (ReviewReply::with('review')->latest('updated_at')->take(5)->get() as $p) {
            $aktivitas->push([
                'waktu' => $p->updated_at,
                'teks'  => 'Kamu membalas ulasan ' . ($p->review->kode_ulasan ?? ''),
            ]);
        }
        $aktivitas = $aktivitas->sortByDesc('waktu')->take(6)->values();

        return view('admin.dashboard', compact('stats', 'dist', 'bulan', 'maxJumlah', 'terbaru', 'aktivitas'));
    }
}
