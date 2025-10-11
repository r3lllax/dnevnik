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
        [$validatedData]=$this->validateQuery($request->query(),[
            'group_id' => 'required|integer|exists:groups,id',
        ]);
        $id = $validatedData['group_id'];
        if($request->user()->role->name == 'Студент' || $request->user()->role->name == 'Староста') {
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
        $strDaysOfWeek = [
          1 => "Понедельник",
          2 => "Вторник",
          3 => "Среда",
          4 => "Четверг",
          5 => "Пятница",
          6 => "Суббота",
          7 => "Воскресенье",
        ];

        $data = collect(Schedule::query()->where(['group_id' => $id])->get()->groupBy(['date']))->map(function ($items,$date) use ($strDaysOfWeek) {
            return [
                'date' => $date,
                'day_of_week_number'=>Carbon::parse($date)->dayOfWeek(),
                'day_of_week_string'=>$strDaysOfWeek[Carbon::parse($date)->dayOfWeek()],
                //TODO Локализация
                //Можно локализировать на уровне сервера, а можно на уровне ответа пользователю(в зависимости от его региона или языка)
                'subjects'=>$items
            ];
        })->values();
        return ['schedule'=>ScheduleDayResource::collection($data)];
    }
}
