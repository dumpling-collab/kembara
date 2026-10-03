<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->timestamp('saved_to_love_board_at')->nullable();
            $table->boolean('is_favorite_route')->default(false);
            $table->string('transport_mode')->nullable(); // 'umum' | 'motor' | 'mobil'
        });

        // Wishlist tempat (tab "Inspirasi Spot" di Love Board)
        Schema::create('place_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'place_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_favorites');

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['saved_to_love_board_at', 'is_favorite_route', 'transport_mode']);
        });
    }
};
