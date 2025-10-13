<?php

namespace App\Http\Resources;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceDatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Attendance $this */
        return [
            'date'=>$this->schedule_day->date,
            'present'=>$this->is_present,
            'reason'=>$this->reason,
            'reasonable'=>$this->reasonable,
        ];
    }
}
