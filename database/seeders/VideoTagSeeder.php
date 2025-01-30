<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Video;
use App\Models\VideoTags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $video_ids = Video::pluck('id')->toArray();
        foreach ($video_ids as $video_id) {
            for($i = 0; $i < rand(10, 20); $i++) {
                $tag_id = fake()->randomElement(Tag::pluck('id')->toArray());
                try {
                    VideoTags::insert([
                        'video_id' => $video_id,
                        'tag_id' => $tag_id
                    ]);
                }
                catch (\Exception $e) {
                    //
                }
            }
        }
    }
}
