<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * All students (includes headman) of group
     * @param Group $group
     * @return JsonResponse
     */
    public function index(Group $group): JsonResponse
    {
        return response()->json([
            'students' => UserResource::collection($group->users),
        ]);
    }
}
