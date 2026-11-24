<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        $link = url('/');

        $svg = (string) QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->errorCorrection('M')
            ->generate($link);

        $svg = preg_replace('/<\?xml.*?\?>\s*/', '', $svg);

        return view('admin.qr', compact('link', 'svg'));
    }
}
