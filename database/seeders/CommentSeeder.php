<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = Video::pluck('id');
        foreach ($videos as $video_id) {
            for ($i = 1; $i <= 25; $i++) {
                try {
                    Comment::insert([
                        'video_id' => $video_id,
                        'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
                        'body' => fake()->sentence()
                    ]);
                }
                catch (\Exception $e) {
                    //skip error
                }
            }
        }
    }
}
