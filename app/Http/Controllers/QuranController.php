<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuranAyahResource;
use App\Http\Resources\QuranSurahResource;
use App\Models\QuranSurah;
use App\Utils\Helper;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    public function getSurahs()
    {
        $surahs = QuranSurah::orderBy('number', 'asc')->get();
        return Helper::ApiResponse('', QuranSurahResource::collection($surahs));
    }
    public function surahDetails($id)
    {
        $surah = QuranSurah::orderBy('number', 'asc')->findOrFail($id);
        return Helper::ApiResponse('', [
            'surah' => QuranSurahResource::make($surah),
            'ayahs' => QuranAyahResource::collection($surah->quran_ayahs),
        ]);
    }
}
