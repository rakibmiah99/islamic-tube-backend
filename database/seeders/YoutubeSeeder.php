<?php

namespace Database\Seeders;

use App\Http\Controllers\YoutubeApiController;
use App\Models\YoutubeChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YoutubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            [
                'name' => "Rose TV",
                'channel_id' => "UCmzT7IffenKCFiqcJkyU7oQ",
            ]
        ];

        YoutubeChannel::insert($channels);

        $youtube_controller = new YoutubeApiController();
        $youtube_controller->run();
        $youtube_controller->runPlayList();
    }
}
