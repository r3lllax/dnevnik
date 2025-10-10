<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Grade Info
     * @param Request $request
     * @param Grade $grade
     * @return JsonResponse
     */
    public function index(Request $request, Grade $grade): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        if ($user->role->name=="Студент"){
            if ($user->grades->contains($grade)){
                return response()->json(GradeResource::make($grade));
            }
            return response()->json([
                'message'=>'Ошибка доступа'
            ],403);
        }
        else if ($user->role->name=="Учитель" || $user->role->name=="Преподаватель")
        {
            if ($grade->subject->teacher->id == $request->user()->id){
                return response()->json(GradeResource::make($grade));
            }
            return response()->json([
                'message'=>'Ошибка доступа.'
            ],403);
        }
        return response()->json([
            'message'=>'Ошибка доступа.'
        ],403);
    }
}
