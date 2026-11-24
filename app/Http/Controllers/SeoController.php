<?php

namespace App\Http\Controllers;

class SeoController extends Controller
{
    public function sitemap()
    {
        $halaman = [
            url('/'),
            route('about'),
            route('catalog.index'),
            route('promo.index'),
            route('review.create'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($halaman as $h) {
            $xml .= '  <url><loc>' . e($h) . '</loc></url>' . "\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $teks = "User-agent: *\n"
              . "Disallow: /admin\n"
              . "Disallow: /dashboard\n"
              . "Disallow: /login\n"
              . "Disallow: /riwayat\n"
              . "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($teks, 200, ['Content-Type' => 'text/plain']);
    }
}
