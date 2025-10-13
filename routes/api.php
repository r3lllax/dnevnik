<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\GroupController;
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

//TODO app_debug false при релизе
//TODO поменять локаль приложения
Route::post('/auth',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // 1 - Admin
    Route::group(['middleware' => ['role:1']], function () {

    });

    // 2 - Teacher
    Route::group(['middleware' => ['role:2']], function () {
        Route::get('/types',function(){
            return response()->json(['types'=>Work_type::all()]);
        });
        Route::post('/job',[WorkController::class,'create']);
        Route::get('/job',[WorkController::class,'index']);
        Route::get('/job/{work}/',[WorkController::class,'show']);
        Route::patch('/job/{work}/edit',[WorkController::class,'edit']);
        Route::patch('/grade/{grade}/edit',[GradeController::class,'edit']);
        Route::post('/student/{user}/add_grade',[GradeController::class,'create']);
        Route::get('/group/{group}/grades',[GradeController::class,'groupGrades']);
        Route::get('/group/{group}',[GroupController::class,'index']);
        Route::get('/attendance/',[AttendanceController::class,'show']);
        Route::post('/attendance/',[AttendanceController::class,'create']); //TODO
    });

    // 3 - Student(includes headman)
    Route::group(['middleware' => ['role:3,4']], function () {
        Route::get('/grades',[GradeController::class,'index']);
    });

    // 4 - headman
    Route::group(['middleware' => ['role:4']], function () {
        Route::get('/attendance/',[AttendanceController::class,'index']);
    });

    //Смешанные

    //Учитель И Ученик(включительно староста):

    Route::group(['middleware' => ['role:3,2,4']], function () {
        Route::get('/grade/{grade}',[GradeController::class,'show']);
    });

    // other - all authorized requests

    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('/semesters',[SemesterController::class,'index']);

    Route::get('/schedule',[ScheduleController::class,'index']);

    Route::get('/test',function(){
        return \App\Models\Attendance::all();
    });
});

