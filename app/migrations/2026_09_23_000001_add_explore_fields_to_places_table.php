<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            // Ringkasan pendek khusus kartu Explore (beda dari 'description' yang panjang di halaman detail)
            $table->text('explore_summary')->nullable();
            // Kotak kutipan opsional yang muncul di sebagian kartu, mis. "Jangan lewatkan sayap kanan..."
            $table->string('highlight_quote')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['explore_summary', 'highlight_quote']);
        });
    }
};
