<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'nama', 'banner', 'deskripsi', 'harga_normal', 'harga_diskon',
        'tanggal_mulai', 'tanggal_berakhir', 'is_active',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_berakhir' => 'date',
        'is_active'        => 'boolean',
    ];

    // Hanya promo yang dinyalakan DAN tanggalnya sedang berlaku
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_berakhir', '>=', now());
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? asset('storage/' . $this->banner) : null;
    }

    // aktif | terjadwal | berakhir | nonaktif
    public function getStatusLabelAttribute(): string
    {
        if (! $this->is_active) return 'nonaktif';
        if (now()->lt($this->tanggal_mulai->startOfDay())) return 'terjadwal';
        if (now()->gt($this->tanggal_berakhir->endOfDay())) return 'berakhir';
        return 'aktif';
    }

    public function getPersenAttribute(): ?int
    {
        if ($this->harga_normal && $this->harga_diskon && $this->harga_normal > 0) {
            return (int) round((1 - $this->harga_diskon / $this->harga_normal) * 100);
        }
        return null;
    }

    public static function rupiah(?int $angka): string
    {
        return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
    }
}
