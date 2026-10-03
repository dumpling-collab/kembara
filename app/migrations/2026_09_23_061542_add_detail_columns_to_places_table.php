<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->string('badge')->nullable();
            $table->unsignedInteger('reviews_count')->default(0);
            $table->string('opening_hours')->nullable();
            $table->string('ticket_price')->nullable();
            $table->string('access_info')->nullable();
            $table->text('bara_story')->nullable();
            $table->text('bara_tip')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['badge', 'reviews_count', 'opening_hours', 'ticket_price', 'access_info', 'bara_story', 'bara_tip']);
        });
    }
};