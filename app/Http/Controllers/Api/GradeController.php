<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Http\Resources\GroupLessonsResource;
use App\Http\Resources\MiniGradeResource;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Grade Info
     * @param Request $request
     * @param Grade $grade
     * @return JsonResponse
     */
    public function show(Request $request, Grade $grade): JsonResponse
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


    /**
     * All student grades for semester
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            'semester_id' => 'required|integer|exists:semesters,id',
        ]);

        /** @var User $user */
        $user = $request->user();
        $data = collect($user->grades()->where('semester_id', $validatedData['semester_id'])->get()->groupBy(['subject_id',function ($item) {
            return $item->work_id === null ? 'advanced_grades' : 'main_grades';
        }]))->map(function ($items,$subject_id) {
            /** @var Subject $subject */
            $subject = Subject::find($subject_id);
            return [
                'id'=>$subject_id,
                'name'=>$subject->name,
                'main_grades'=>MiniGradeResource::collection($items['main_grades']),
                'advanced_grades'=>array_key_exists('advanced_grades', $items->toArray())?MiniGradeResource::collection($items['advanced_grades']):[],
            ];
        })->values();

        //Привожу к тому же виду для поиска отсутсвующих предметов
        $compareResponse = $data->map(function ($item){
           return[
               $item['name'],
           ];
        });

        //Все предметы у группы студента
        $allSubjects = GroupLessonsResource::collection($user->group->group_lessons)->map(function ($item){
            return $item->subject->name;
        });

        //Наши предметы в одномерный массив
        $flatten = $compareResponse->flatten();

        //Пусто - значит нет разницы
        $isSubset = $allSubjects->diff($flatten)->isEmpty();

        if (!$isSubset) {
            $missingItems = $allSubjects->diff($flatten);
            foreach ($missingItems as $missingItem) {
                $subj = Subject::query()->where('name',$missingItem)->first();
                $data[] = [
                      'id'=>$subj->id,
                      'name'=>$subj->name,
                      'main_grades'=>[],
                      'advanced_grades'=>[]
                    ];
            }
        }

        return response()->json(['subjects'=>$data]);

    }

    /**
     * Add grade to student
     * @param CreateGradeRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function create(CreateGradeRequest $request,User $user): JsonResponse
    {
        $validatedData = $request->validated();
        //TODO в целом решить вопрос о том, хардкодить роли по айдишнику или по имени,пока пусть будет по имени
        if ($user->role->name!="Студент"){
            return response()->json([
                'message'=>'Данный пользователь не является учеником'
            ],403);
        }
        $initials = $user->initials();
        /** @var Subject $targetSubject */
        $targetSubject = Subject::find($validatedData['subject_id']);

        //TODO Рефактор более простым методом (уверен он есть)
        $contains = collect($user->group->subjects)->pluck('id')->filter(function ($item) use ($targetSubject) {return $targetSubject->id == $item;})->values();
        //Проверка на то что такой предмет вообще преподается у ученика
        if($contains->isEmpty()){
            return response()->json([
                'message'=>"У ученика \"$initials\" не ведется предмет \"$targetSubject->name\""
            ],403);
        }

        //Проверка ведет ли преподаватель предмет у ученика
        if (!($targetSubject->teacher->id == $request->user()->id)){
            return response()->json([
                'message'=>"Вы не ведете предмет \"$targetSubject->name\" у ученика \"$initials\""
            ],403);
        }

        //Проверка на то, что оценка за эту работу уже стоит у ученика
        if (array_key_exists('work_id',$validatedData) && !($user->grades()->where('work_id', $validatedData['work_id'])->get()->isEmpty())){
            return response()->json([
                'message'=>"Ученик уже имеет оценку по данной работе, для исправления выберете соответствующую функцию"
            ],403);
        }
        if (!array_key_exists('semester_id',$validatedData)){
            [$semesters,$index] = $this->getCurrentSemester();
            $validatedData['semester_id'] = $semesters[$index]->id;
        }

        $validatedData['date'] = Carbon::now()->format('Y-m-d');

        /** @var Grade $createdGrade */
        $createdGrade = $user->grades()->create($validatedData);
        $theme = $createdGrade->work?$createdGrade->work->theme:false;
        return response()->json([
            'message'=>$theme?"Оценка \"$createdGrade->grade\" за работу \"$theme\" выставлена":"Оценка \"$createdGrade->grade\" выставлена",
        ]);

    }
}
