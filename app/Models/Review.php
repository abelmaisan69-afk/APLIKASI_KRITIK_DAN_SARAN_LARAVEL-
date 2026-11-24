<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    protected $fillable = ['kode_ulasan', 'review_category_id', 'nama', 'rating', 'isi', 'status'];

    protected static function booted(): void
    {
        static::creating(function (Review $review) {
            do {
                $kode = 'ULS-' . strtoupper(Str::random(8));
            } while (static::where('kode_ulasan', $kode)->exists());

            $review->kode_ulasan = $kode;
        });
    }

    public function category()
    {
        return $this->belongsTo(ReviewCategory::class, 'review_category_id');
    }

    public function reply()
    {
        return $this->hasOne(ReviewReply::class);
    }
}
