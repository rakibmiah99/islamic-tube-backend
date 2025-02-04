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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable()->default(null);
            $table->string('thumbnail', 2000);
            $table->string('thumbnail_md', 2000)->nullable()->default(null);
            $table->string('thumbnail_sm', 2000)->nullable()->default(null);
            $table->longText('long_description')->nullable()->default(null);
            $table->string('provider');
            $table->string('video_id')->nullable();
            $table->dateTime('published_at')->nullable()->default(date('Y-m-d H:i:s'));
            $table->unique('slug', 'videos_slug_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
