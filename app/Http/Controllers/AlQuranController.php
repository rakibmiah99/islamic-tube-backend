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
                    'arabic_name' => $item['name'],
                    'english_name' => $item['englishName'],
                    'bangla_name' => $bangla_info['name'],
                    'bangla_name_translation' => $bangla_info['translation_name'],
                    'number_of_ayahs' => $item['numberOfAyahs'],
                    'revelation_type' => $item['revelationType'],
                ];
            });
        }

        return Helper::ApiResponse('', $data);
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
