<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = Video::factory()->count(100)->make();
        try {
            $videos->each(function ($video) {
                $video->save();
            });
        }
        catch (\Exception $exception){
//            dd($exception->getMessage());
            //skip error
        }
    }
}
