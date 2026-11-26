<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $opsi = ['7h' => '7 Hari', '30h' => '30 Hari', '6b' => '6 Bulan', '12b' => '12 Bulan'];

        $periode = (string) $request->query('periode', '6b');
        if (! array_key_exists($periode, $opsi)) {
            $periode = '6b';
        }

        // ===== Slot waktu (per hari atau per bulan) =====
        if (str_ends_with($periode, 'h')) {
            $jumlahHari = (int) $periode;
            $mulai      = now()->startOfDay()->subDays($jumlahHari - 1);
            $format     = 'Y-m-d';
            $slots      = collect(range(0, $jumlahHari - 1))->map(fn ($i) => $mulai->copy()->addDays($i));
            $labelFmt   = $jumlahHari <= 7 ? 'D, d M' : 'd M';
        } else {
            $jumlahBulan = $periode === '12b' ? 12 : 6;
            $mulai       = now()->startOfMonth()->subMonths($jumlahBulan - 1);
            $format      = 'Y-m';
            $slots       = collect(range(0, $jumlahBulan - 1))->map(fn ($i) => $mulai->copy()->addMonths($i));
            $labelFmt    = $jumlahBulan > 6 ? 'M y' : 'M';
        }

        $perSlot = Review::tampil()
            ->where('created_at', '>=', $mulai)
            ->get(['rating', 'created_at'])
            ->groupBy(fn ($r) => $r->created_at->format($format));

        $labels = $jumlah = $rata = [];
        foreach ($slots as $slot) {
            $grup     = $perSlot->get($slot->format($format), collect());
            $labels[] = $slot->translatedFormat($labelFmt);
            $jumlah[] = $grup->count();
            $rata[]   = $grup->count() ? round($grup->avg('rating'), 2) : null;
        }

        // ===== Distribusi bintang (semua waktu, urutan 5 -> 1) =====
        $distRaw = Review::tampil()
            ->selectRaw('rating, COUNT(*) as jml')
            ->groupBy('rating')
            ->pluck('jml', 'rating');

        $dist = [];
        for ($i = 5; $i >= 1; $i--) {
            $dist[] = (int) ($distRaw[$i] ?? 0);
        }

        $grafik = compact('labels', 'jumlah', 'rata', 'dist');

        // ===== Kartu statistik =====
        $stats = [
            'total'   => Review::tampil()->count(),
            'rata'    => round(Review::tampil()->avg('rating') ?? 0, 1),
            'lima'    => Review::tampil()->where('rating', 5)->count(),
            'belum'   => Review::where('status', 'belum_dibalas')->count(),
            'periode' => array_sum($jumlah),
        ];

        $terbaru = Review::with('category')->latest()->take(5)->get();

        // ===== Aktivitas =====
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

        return view('admin.dashboard', compact('opsi', 'periode', 'stats', 'grafik', 'terbaru', 'aktivitas'));
    }
}