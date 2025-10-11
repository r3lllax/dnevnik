<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SemesterController;
use App\Http\Controllers\Api\WorkController;
use App\Models\Semester;
use App\Models\User;
use App\Models\Work_type;
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
        Route::get('/types',function(){
            return response()->json(Work_type::all());
        });
        Route::post('/job',[WorkController::class,'create']);
        Route::patch('/job/{work}/edit',[WorkController::class,'edit']);
        Route::patch('/grade/{grade}/edit',[GradeController::class,'edit']);
        Route::post('/student/{user}/add_grade',[GradeController::class,'create']);
        Route::get('/group/{group}/grades',[GradeController::class,'groupGrades']);
    });

    // 3 - Student
    Route::group(['middleware' => ['role:3']], function () {
        Route::get('/grades',[GradeController::class,'index']);
    });

    //Смешанные

    //Учитель И Ученик:

    Route::group(['middleware' => ['role:3,2']], function () {
        Route::get('/grade/{grade}',[GradeController::class,'show']);
    });

    // other - all authorized requests

    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('/semesters',[SemesterController::class,'index']);

    Route::get('/schedule',[ScheduleController::class,'index']);

    Route::get('/test',function(){
        /** @var User $user */
        $user = auth()->user();
        return $user->group->schedule[0]->time;
    });
});

