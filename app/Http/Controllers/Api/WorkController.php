<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkRequest;
use App\Http\Requests\EditWorkRequest;
use App\Models\Subject;
use App\Models\Work;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * create work
     * @param CreateWorkRequest $request
     * @return JsonResponse
     */
    public function create(CreateWorkRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        /** @var Subject $targetSubject */
        $targetSubject = Subject::find($validatedData['subject_id']);
        if ($targetSubject->teacher->id===$request->user()->id){

            /** @var Work $createdWork */
            $createdWork = Work::create($validatedData);
            return response()->json([
                'success'=>'true',
                'message'=>"Тема \"$createdWork->theme\" успешно создана!"
            ]);
        }
        return response()->json([
            'message'=>"Вы не ведете предмет \"$targetSubject->name\""
        ],403);
    }

    /**
     * Edit teacher`s work
     * @param EditWorkRequest $request
     * @param Work $work
     * @return JsonResponse
     */
    public function edit(EditWorkRequest $request,Work $work): JsonResponse
    {
        if ($work->subject->teacher->id===$request->user()->id){
            //TODO добавить защиту от одинаковых данных (пришли с фронта без изменения)
            $updatedWork = $work->fill($request->validated());
            return response()->json([
                'success'=>'true',
                'message'=>"Тема \"$updatedWork->theme\" успешно изменена!"
            ]);
        }
        return response()->json([
            'message'=>'Вы не являетесь создателем этой работы'
        ],403);
    }
}
