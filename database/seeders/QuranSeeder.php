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
        $audio = $quran_controller->audio();
        $surahs_in_english = $quran_controller->english();
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        DB::statement('truncate table quran_ayahs');
        DB::statement('truncate table quran_surahs');
        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        $surahs = $quran_controller->getAllSurah();

        QuranSurah::insert($surahs->toArray());

        foreach ($surahs_in_english as $surah) {
            $surah_number = $surah['number'];
            foreach ($surah['ayahs'] as $ayah) {
                $data = [
                    'number' => $ayah['number'],
                    'surah_number' => $surah_number,
                    'number_in_surah' => $ayah['numberInSurah'],
                    'juz' => $ayah['juz'],
                    'manzil' => $ayah['manzil'],
                    'page' => $ayah['page'],
                    'ruku' => $ayah['ruku'],
                    'hizb_quarter' => $ayah['hizbQuarter'],
                    'sajda' => json_encode($ayah['sajda']),
                    'text_in_en' => $ayah['text']
                ];

                QuranAyah::insert($data);
            }
        }


        foreach ($audio as $ayah) {
            QuranAyah::where($ayah['condition'])->update($ayah['data']);
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
    }
}
