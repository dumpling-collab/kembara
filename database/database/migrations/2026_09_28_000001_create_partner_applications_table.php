<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_applications', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('owner_name');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('category'); // Kuliner | Fashion | Lainnya
            $table->string('location');
            $table->text('products');
            $table->string('social_link')->nullable();
            $table->text('description');
            $table->string('status')->default('pending'); // pending | reviewed | accepted | rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_applications');
    }
};
