<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('starting_point_name')->nullable();
            $table->decimal('starting_point_lat', 10, 7)->nullable();
            $table->decimal('starting_point_lng', 10, 7)->nullable();
        });

        Schema::table('places', function (Blueprint $table) {
            // Perkiraan lama kunjungan di tempat itu (dipakai di layar "Titik Awal")
            $table->unsignedSmallInteger('visit_duration_min')->nullable();
            $table->unsignedSmallInteger('visit_duration_max')->nullable();
            // Label aktivitas singkat, mis. "Eksplorasi & Foto-foto"
            $table->string('activity_tag')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['starting_point_name', 'starting_point_lat', 'starting_point_lng']);
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['visit_duration_min', 'visit_duration_max', 'activity_tag']);
        });
    }
};
