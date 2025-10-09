<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'=>'required|string|exists:users,login',
            'password'=>'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=>'Ошибка авторизации',
                'errors'=>[
                     'password'=>'Неправильный логин или пароль'
                ]
            ], 422);
        }

        if(auth()->attempt($validator->validated())){
            /** @var User $user */
            $user = auth()->user();
            $userResponce = [...$user->toArray()];
            unset($userResponce['group_id']);
            unset($userResponce['created_at']);
            //TODO Ресурс и ответ по документации и ТОКЕН
            return response()->json([
                'user'=>[
                    ...$userResponce,
                    'group'=>$user->group,
                ],
                'token'=>$user->createToken('api')->plainTextToken,
            ]);
        }
        return response()->json([
            'message'=>'Ошибка авторизации',
            'errors'=>[
                'password'=>'Неправильный логин или пароль'
            ]
        ], 422);
    }
}
