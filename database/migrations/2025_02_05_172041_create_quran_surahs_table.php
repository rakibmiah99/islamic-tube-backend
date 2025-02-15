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
        Schema::create('quran_surahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number');
            $table->integer('number_of_ayahs');
            $table->string('revelation_type');
            $table->string('name_in_ar');
            $table->string('name_in_bn');
            $table->string('name_in_en');
            $table->string('translate_in_bn');
            $table->string('translate_in_en')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_surahs');
    }
};
