<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->string('kode_ulasan', 12)->unique();
    $table->foreignId('review_category_id')->constrained()->cascadeOnDelete();
    $table->string('nama')->nullable();
    $table->unsignedTinyInteger('rating');
    $table->text('isi');
    $table->enum('status', ['belum_dibalas', 'sudah_dibalas', 'disembunyikan'])
          ->default('belum_dibalas');
    $table->timestamps();
}); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
