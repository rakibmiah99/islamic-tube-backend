<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuranAyahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'surah_number' => $this['surah_number'],
            'number' => $this['number'],
            'number_in_surah' => $this['number_in_surah'],
            'manzil' => $this['manzil'],
            'page' => $this['page'],
            'ruku' => $this['ruku'],
            'hizb_quarter' => $this['hizb_quarter'],
            'sajda' => json_decode($this['sajda'], true),
            'text_in_ar' => $this['text_in_ar'],
            'text_in_bn' => $this['text_in_bn'],
            'audio_in_ar' => $this['audio_in_ar'] ?? $this['audio_in_ar_secondary'],
        ];
    }
}
