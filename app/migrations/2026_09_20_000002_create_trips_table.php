<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('budget')->default(0); // Rupiah
            $table->string('status')->default('draft');       // draft|planned|done
            $table->timestamps();
        });

        Schema::create('place_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            $table->unique(['trip_id', 'place_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_trip');
        Schema::dropIfExists('trips');
    }
};
