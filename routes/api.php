<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\withMiddleware as withMiddlewareAlias;

Route::post('/auth',[AuthController::class,'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/test',function(){
        /** @var User $user */
        $user = auth()->user();
        return $user->group;
    });
});

