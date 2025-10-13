<?php

namespace App\Http\Resources;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceDatesHeadmanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Attendance $this */
        //TODO Добавлять ли reasonable (например для выделения ячейки в таблице)
        return [
            'date'=>$this->schedule_day->date,
            'passed_hours'=>$this->passed_hours,
        ];
    }
}
