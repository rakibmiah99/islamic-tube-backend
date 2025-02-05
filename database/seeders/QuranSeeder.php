<?php

namespace Database\Seeders;

use App\Http\Controllers\AlQuranController;
use App\Models\QuranAyah;
use App\Models\QuranSurah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quran_controller = new AlQuranController();
        $all_ayahs = $quran_controller->audio();
        DB::statement('truncate table quran_ayahs');
        DB::statement('truncate table quran_surahs');

        foreach ($all_ayahs as $ayah) {
            QuranAyah::insert($ayah);
        }

        $bangla_ayahs = $quran_controller->bangla();

        foreach ($bangla_ayahs as $ayah) {
            QuranAyah::where([
                'number' => $ayah['number'],
                'number_in_surah' => $ayah['number_in_surah'],
            ])->update([
                'text_in_bn' => $ayah['text_in_bn'],
            ]);
        }

        $surahs = $quran_controller->getAllSurah();

        QuranSurah::insert($surahs->toArray());

    }
}
