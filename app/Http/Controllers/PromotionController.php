<?php

namespace App\Http\Controllers;

use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::aktif()->orderBy('tanggal_berakhir')->get();

        return view('promo.index', compact('promotions'));
    }
}
