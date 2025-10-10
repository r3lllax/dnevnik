<?php

namespace App\Http\Resources;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectInScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Schedule $item */
        $item = $this;

        $subject = $item->subject;

        $time = $item->time;

        $teacher = $item->teacher;

        return [
            'name' => $subject->name,
            'time' => $time->start_time,
            'teacher' => $teacher->initials(),
            'room' => $item->room->name,
            'comment' => $item->comment,
            'highlight' => $item->highlight?"true":"false",
        ];
    }
}
