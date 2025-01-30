<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\VideoWatchCount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoWatchCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       for($i = 1; $i <= 500; $i++) {
           VideoWatchCount::insert([
               'video_id' => fake()->randomElement(Video::pluck('id')->toArray()),
               'ip' => fake()->ipv4(),
               'watch_date' => fake()->date(),
               'watch_count' => fake()->randomDigit(),
           ]);
       }
    }
}
