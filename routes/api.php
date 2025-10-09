<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\withMiddleware as withMiddlewareAlias;

Route::post('/auth',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout',[AuthController::class,'logout']);

    // 1 - Admin
    Route::group(['middleware' => ['role:1']], function () {

    });

    // 2 - Teacher
    Route::group(['middleware' => ['role:2']], function () {

    });

    // 3 - Student
    Route::group(['middleware' => ['role:3']], function () {

    });

    // other - all authorized requests

    Route::get('/semesters',function(){
        return response()->json([
            'semesters' => Semester::all()
        ]);
    });
    Route::get('/test',function(){
        /** @var User $user */
        $user = auth()->user();
        return $user->group->schedule[0]->time;
    });
});

