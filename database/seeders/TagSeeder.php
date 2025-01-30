<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = Tag::factory()->count(100)->make();
        try {
            $tag->each(function ($video) {
                $video->save();
            });
        }
        catch (\Exception $exception){
//            dd($exception->getMessage());
            //skip error
        }
    }
}
