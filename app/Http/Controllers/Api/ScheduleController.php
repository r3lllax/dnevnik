<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleDayResource;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Returns all schedule of a group
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $id = $request->get('group_id');
        //TODO не кореектно работает exists (вообще не работает)
        $validator = Validator::make($request->query(), [
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        if($request->user()->role->name == 'Студент') {
            if($id == $request->user()->group_id){
                return response()->json([$this->getSchedule($id)]);
            }
            return response()->json([
                'message' => 'Не найдено'
            ],404);
        }

        return response()->json([$this->getSchedule($id)]);


    }

    /**
     * reusable function to get schedule in general form
     * @param $id
     * @return array
     */
    private function getSchedule($id): array
    {
        $data = collect(Schedule::query()->where(['group_id' => $id])->get()->groupBy(['date']))->map(function ($items,$date) {
            return [
                'date' => $date,
                'day_of_week'=>Carbon::parse($date)->dayOfWeek(),
                'subjects'=>$items
            ];
        })->values();
        return ['schedule'=>ScheduleDayResource::collection($data)];
    }
}
