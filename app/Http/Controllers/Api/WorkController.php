<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkRequest;
use App\Http\Requests\EditWorkRequest;
use App\Http\Resources\WorkResource;
use App\Http\Resources\WorksFromSubjectResource;
use App\Models\Subject;
use App\Models\Work;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    /**
     * get works by subject id, even with another id but same name(it possible if 2 teachers teach 1 subject)
     * @param Request $request
     * @return array|JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request): array|JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            'subject_id'=>'required|integer|exists:subjects,id',
        ]);

        /** @var Subject $subject */
        $subject = Subject::find($validatedData['subject_id']);


        $reqUserSubjects = $request->user()->subjects->map(function ($item) {
            return $item->name;
        })->values();

        if (!($reqUserSubjects->contains($subject->name))){
            return response()->json([
                'message'=>"Вы не ведете предмет \"$subject->name\""
            ],403);
        }


        return WorksFromSubjectResource::collection(Subject::query()->where('name',$subject->name)->get())->collection->pluck('works')->collapse()->map(function ($item){
            return WorkResource::make($item);
        })->toArray();

    }

    /**
     * @param Request $request
     * @param Work $work
     * @return JsonResponse
     */
    public function show(Request $request,Work $work): JsonResponse
    {
        if($request->user()->subjects->map(function ($item) {
            return $item->name;
        })->values()->contains($work->subject->name)){
            return response()->json([
                'id'=>$work->id,
                'subject'=>[
                    'id'=>$work->subject->id,
                    'name'=>$work->subject->name,
                ],
                'theme'=>$work->theme,
                'date'=>$work->date,
            ]);

        }
        $subject = $work->subject;
        return response()->json([
            'message'=>"Вы не можете посмотреть данную работу, так как не ведете ее предмет (\"$subject->name\")"
        ],403);
    }


}
