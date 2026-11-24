<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReviewCategory;

class ReviewCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         foreach (['Kualitas Produk', 'Pelayanan', 'Harga', 'Kebersihan', 'Pengalaman Keseluruhan'] as $nama) {
        ReviewCategory::firstOrCreate(['nama' => $nama]);
    }
    }
}
