<?php

namespace App\Models;

use App\Http\Resources\QuranSurahResource;
use App\Utils\Helper;
use Illuminate\Database\Eloquent\Model;

class QuranSurah extends Model
{

    public function quran_ayahs()
    {
        return $this->hasMany(QuranAyah::class, 'surah_number', 'number');
    }
}
