<?php

namespace App\Http\Resources;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Work $work */
        $work = $this;
        return [
            'id' => $work->id,
            'theme'=>$work->theme,
            'date'=>$work->date,
            'type'=>$work->type->name,
        ];
    }
}
