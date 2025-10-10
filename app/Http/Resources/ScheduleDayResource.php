<?php

namespace App\Http\Resources;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleDayResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date'=>$this['date'],
            'day_of_week'=>$this['day_of_week'],
            'subjects'=>SubjectInScheduleResource::collection($this['subjects']),
        ];
    }
}
