<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // Nilai awal sebelum admin mengisi apa pun
    public const DEFAULTS = [
        'nama_usaha'      => 'Usaha Kami',
        'tahun_berdiri'   => '',
        'alamat'          => '',
        'whatsapp'        => '',
        'email'           => '',
        'instagram'       => '',
        'jam_operasional' => '',
        'deskripsi_usaha' => 'Selamat datang di website kami.',

        'hero_headline'    => 'Produk Berkualitas, Pelayanan Sepenuh Hati',
        'hero_subheadline' => 'Temukan produk terbaik kami dan bagikan pengalamanmu.',
        'hero_btn1_text'   => 'Lihat Produk',
        'hero_btn2_text'   => 'Berikan Ulasan',
        'about_story'      => '',
        'visi'             => '',
        'misi'             => '',
        'nilai'            => '',
        'cta_title'        => 'Bagaimana Pengalaman Anda Berbelanja di Sini?',
        'cta_text'         => 'Rating dan ulasanmu membantu kami menjadi lebih baik.',
        'footer_text'      => '',

        'color_primary'   => '#0F5132',
        'color_secondary' => '#DFF3E7',
        'color_accent'    => '#F5B942',
        'color_button'    => '',


    ];

    public const PRESETS = [
    'Hijau Klasik' => ['#0F5132', '#DFF3E7', '#F5B942', '#0F5132'],
    'Hijau Zamrud' => ['#065F46', '#D1FAE5', '#F59E0B', '#047857'],
    'Biru Laut'    => ['#0C4A6E', '#E0F2FE', '#F59E0B', '#0369A1'],
    'Terakota'     => ['#9A3412', '#FFEDD5', '#FACC15', '#C2410C'],
    'Ungu Elegan'  => ['#5B21B6', '#EDE9FE', '#F59E0B', '#6D28D9'],
    'Kopi Hangat'  => ['#4E342E', '#F5EBE0', '#D4A373', '#6F4E37'],
    'Mawar'        => ['#9F1239', '#FFE4E6', '#FBBF24', '#BE123C'],
];



// campur dua warna hex, hasilnya "r g b"
public static function mix(string $hex, string $with, float $ratio): string
{
    $a = array_map('hexdec', str_split(ltrim($hex, '#'), 2));
    $b = array_map('hexdec', str_split(ltrim($with, '#'), 2));
    $out = [];
    foreach ($a as $i => $v) {
        $out[] = (int) round($v * (1 - $ratio) + $b[$i] * $ratio);
    }
    return implode(' ', $out);
}

    private static ?array $memo = null;

    public static function semua(): array
    {
        if (self::$memo === null) {
            try {
                $db = static::pluck('value', 'key')->all();
            } catch (\Throwable $e) {
                $db = []; // tabel belum ada (sebelum migrate)
            }

            $db = array_filter($db, fn ($v) => $v !== null && $v !== '');
            self::$memo = array_merge(self::DEFAULTS, $db);
        }

        return self::$memo;
    }

    public static function put(array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        self::$memo = null;
    }

    public static function url(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }

    // "#0F5132" -> "15 81 50" (supaya Tailwind bisa memakai opacity seperti bg-primary/30)
    public static function rgb(string $hex): string
    {
        $hex = ltrim($hex, '#');
        return implode(' ', array_map('hexdec', str_split($hex, 2)));
    }
}
