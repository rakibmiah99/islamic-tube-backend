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
        Schema::create('youtube_play_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('youtube_channel_id');
            $table->string('playlist_id');
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
            $table->foreign('youtube_channel_id')->references('id')->on('youtube_channels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_play_lists');
    }
};
