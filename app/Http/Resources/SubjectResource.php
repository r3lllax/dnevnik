<?php

namespace App\Http\Resources;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Subject $subject */
        $subject = $this;
        return [
            'name' => $subject->name,
            'teacher'=>$subject->teacher->initials(),
            //TODO semester объект узнать
            //semester

        ];
    }
}
