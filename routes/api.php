<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Models\Semester;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\withMiddleware as withMiddlewareAlias;

Route::post('/auth',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // 1 - Admin
    Route::group(['middleware' => ['role:1']], function () {

    });

    // 2 - Teacher
    Route::group(['middleware' => ['role:2']], function () {

    });

    // 3 - Student
    Route::group(['middleware' => ['role:3']], function () {

    });

    //Смешанные

    //Учитель И Ученик:

    Route::group(['middleware' => ['role:3,2']], function () {
        Route::get('/grade/{grade}',[GradeController::class,'index']);
    });

    // other - all authorized requests

    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('/semesters',function(){
        //TODO Вынести логику из рутов
        /** @var Semester $semesters */
        $semesters = Semester::all();
        $index = 0;
        foreach($semesters as $item){
            $now = Carbon::now();
            $start = Carbon::parse($item->from);
            $end = Carbon::parse($item->to);
            if ($now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end)) {
                break;
            }
            $index++;
        }
        $otherSemesters = $semesters->toArray();
        unset($otherSemesters[$index]);
        return response()->json([
            'semesters' => [
                'current' => $semesters[$index],
                'other'=>$otherSemesters
            ]
        ]);
    });

    Route::get('/schedule',[ScheduleController::class,'index']);

    Route::get('/test',function(){
        /** @var User $user */
        $user = auth()->user();
        return $user->group->schedule[0]->time;
    });
});

