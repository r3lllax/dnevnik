<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login to account
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
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
            $userResponse = [...$user->toArray()];
            unset($userResponse['group_id']);
            unset($userResponse['created_at']);
            return response()->json([
                'user'=>[
                    ...$userResponse,
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

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json([],204);
    }
}
