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
        Schema::create('quran_ayahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('surah_number');
            $table->unsignedInteger('number');
            $table->unsignedInteger('number_in_surah');
            $table->unsignedInteger('juz')->comment('para');
            $table->unsignedInteger('manzil');
            $table->unsignedInteger('page');
            $table->unsignedInteger('ruku');
            $table->unsignedInteger('hizb_quarter');
            $table->json('sajda');
            $table->string('text_in_ar', 2000)->nullable()->default(null);
            $table->string('text_in_bn', 2000)->nullable()->default(null);
            $table->string('text_in_en', 2000)->nullable()->default(null);
            $table->string('audio_in_ar', 2000)->nullable()->default(null);
            $table->string('audio_in_ar_secondary', 2000)->nullable()->default(null);
            $table->string('audio_in_bn', 2000)->nullable()->default(null);
            $table->string('audio_in_en', 2000)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_ayahs');
    }
};
