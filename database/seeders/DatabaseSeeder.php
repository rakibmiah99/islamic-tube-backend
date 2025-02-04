<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        Artisan::call('migrate:fresh');
        $this->call(UserSeeder::class);
//        $this->call(VideoSeeder::class);
        $this->call(YoutubeSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(VideoTagSeeder::class);
        $this->call(VideoWatchCountSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(VideoReactionSeeder::class);
    }
}
