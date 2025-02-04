<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoReaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $video_ids = Video::pluck('id')->toArray();
        foreach ($video_ids as $video_id) {
            for($i = 0; $i < 30; $i++){
                try {
                    VideoReaction::create([
                        'video_id' => $video_id,
                        'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
                        'reaction' => fake()->randomElement(['l', 'd', 'n'])
                    ]);
                }
                catch (\Exception $exception){
                    //skip errors
                }

            }
        }
    }
}
