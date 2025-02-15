<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuranSurahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'number_of_ayahs' => $this->number_of_ayahs,
            'revelation_type' => $this->revelation_type,
            'name_in_ar' => $this->name_in_ar,
            'name_in_bn' => $this->name_in_bn,
            'translate_in_bn' => $this->translate_in_bn
        ];
    }
}
