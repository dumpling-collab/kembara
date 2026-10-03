<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Saldo credit sungguhan (bukan lagi dihitung on-the-fly). Default 80
            // berarti user baru otomatis dapat 80 credit saat daftar.
            $table->unsignedInteger('credits')->default(80);
        });

        Schema::create('challenge_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('challenge_checkpoint_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('challenge_checkpoint_id')->constrained()->cascadeOnDelete();
            $table->timestamp('verified_at')->useCurrent();
            $table->unique(['user_id', 'challenge_checkpoint_id'], 'checkpoint_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_checkpoint_user');
        Schema::dropIfExists('challenge_checkpoints');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('credits');
        });
    }
};
