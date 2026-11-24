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
       Schema::create('promotions', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('banner')->nullable();
    $table->text('deskripsi')->nullable();
    $table->unsignedInteger('harga_normal')->nullable();
    $table->unsignedInteger('harga_diskon')->nullable();
    $table->date('tanggal_mulai');
    $table->date('tanggal_berakhir');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
