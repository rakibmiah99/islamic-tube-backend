<?php

namespace App\Http\Controllers;

use App\Trait\QuranTrait;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AlQuranController extends Controller
{
    use QuranTrait;
    public function request()
    {
        return Http::baseUrl('http://api.alquran.cloud/v1');
    }


    public function bangla(){
        return Cache::remember('alquran-bangla', now()->addHours(40), function () {
            $response = $this->request()->get('/quran/bn.bengali');
            if ($response->status() == 200) {
                $data = collect($response->json()['data']['surahs']);
                return $data->flatMap->ayahs->map(function ($ayahs) {
                    return [
                        'number' => $ayahs['number'],
                        'number_in_surah' => $ayahs['numberInSurah'],
                        'text_in_bn' => $ayahs['text'],
                    ];
                });
            }
        });
    }
    public function english(){
        return Cache::remember('alquran-english', now()->addHours(40), function () {
            $response = $this->request()->get('/quran/en.asad');
            if ($response->status() == 200) {
                $data = $response->json()['data']['surahs'];
                return $data;
            }
        });
    }

    public function audio()
    {
        return Cache::remember('alquran-audio', now()->addHours(40), function () {
            $response = $this->request()->get('/quran/ar.alafasy');
            if ($response->status() == 200) {
                $data = $response->json()['data']['surahs'];
                $data = collect($data);
                return $data->flatMap->ayahs->map(function ($ayah) {
                    return [
                        'condition' => [
                            'number' => $ayah['number'],
                            'number_in_surah' => $ayah['numberInSurah'],
                        ],
                        'data' => [
                            'text_in_ar' => $ayah['text'],
                            'audio_in_ar' => $ayah['audio'],
                            'audio_in_ar_secondary' => $ayah['audioSecondary'][0] ?? null,
                        ]

                    ];
                });
            }
        });
    }

    public function index()
    {
        $response = $this->request()->get('/edition/language/bn');
        $data = [];
        if ($response->status() == 200) {
            $data = $response->json()['data'];
        }

        return Helper::ApiResponse('', $data);
    }

    public function getAllSurah()
    {
        $response = $this->request()->get('/surah');
        $data = [];
        if ($response->status() == 200) {
            $data = collect($response->json()['data'])->map(function ($item) {
                $surah_number = $item['number'];
                $bangla_info = $this->surah_name_bangla[$surah_number];

                return [
                    'number' => $item['number'],
                    'number_of_ayahs' => $item['numberOfAyahs'],
                    'revelation_type' => $item['revelationType'],
                    'name_in_ar' => $item['name'],
                    'name_in_en' => $item['englishName'],
                    'name_in_bn' => $bangla_info['name'],
                    'translate_in_bn' => $bangla_info['translation_name'],
                    'translate_in_en' => $item['englishNameTranslation'],
                ];
            });
        }

        return $data;
    }
    public function getSurahAyahs($surah_number)
    {
        return Cache::remember("surah_$surah_number", now()->addHours(6), function () use ($surah_number) {
            $response = $this->request()->get("/surah/$surah_number/editions/quran-uthmani,bn.bengali");
            $data = [];

            if ($response->status() == 200) {
                $data = $response->json()['data'];

                $arabic_info = collect($data[0]);
                $bangla_info = collect($data[1]);
                $bangla_ayahs = $bangla_info['ayahs'];


                $all_ayahs = collect($arabic_info['ayahs'])->map(function ($item, $index) use ($bangla_ayahs) {
                    return [
                        'ayah_number' => $item['numberInSurah'],
                        'ayah_info' => [
                            'arabic' => $item,
                            'bangla' => $bangla_ayahs[$index],
                        ]
                    ];
                });


                $bangla_info = collect($data[1])->except(['edition']);
                $bangla_info['bangla_name'] = $this->surah_name_bangla[$surah_number]['name'];
                $bangla_info['bangla_name_translation'] = $this->surah_name_bangla[$surah_number]['translation_name'];

                return [
                    'surah_info' => collect($bangla_info)->except(['ayahs', 'edition']),
                    'ayahs' => $all_ayahs
                ];
            }

            return Helper::ApiResponse('', $data);
        });
    }
}
