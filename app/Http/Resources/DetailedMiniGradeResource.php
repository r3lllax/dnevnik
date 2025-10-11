<?php

namespace App\Http\Resources;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedMiniGradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Grade $grade */
        $grade = $this;
        return [
            'date'=>$grade->date,
            'grade'=>[
                'id'=>$grade->id,
                'value'=>$grade->grade,
            ]
        ];
    }
}
