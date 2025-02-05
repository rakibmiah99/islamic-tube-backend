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
        Schema::create('user_play_list_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_play_list_id');
            $table->unsignedBigInteger('video_id');
            $table->unique(['user_id', 'user_play_list_id', 'video_id']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_play_list_id')->references('id')->on('user_play_lists');
            $table->foreign('video_id')->references('id')->on('videos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_play_list_videos');
    }
};
