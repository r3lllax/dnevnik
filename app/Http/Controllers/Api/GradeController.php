<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGradeRequest;
use App\Http\Requests\EditGradeRequest;
use App\Http\Resources\DetailedMiniGradeResource;
use App\Http\Resources\GradeResource;
use App\Http\Resources\GroupLessonsResource;
use App\Http\Resources\MiniGradeResource;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        if ($user->role->name=="Студент" || $user->role->name=="Староста"){
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
        if ($user->role->name=="Студент" || $user->role->name=="Староста"){
            return response()->json([
                'message'=>'Данный пользователь не является учеником'
            ],403);
        }


        $initials = $user->initials();

        /** @var Subject $targetSubject */
        $targetSubject = Subject::find($validatedData['subject_id']);

        $work = Work::find($validatedData['work_id']);
        if(!($work->subject->name===$targetSubject->name)){
            return response()->json([
                'message'=>"Тема \"$work->theme\" не относится к предмету \"$targetSubject->name\""
            ],403);
        }

        //Проверка что преподаватель вообще ведет этот предмет
        if (!($targetSubject->teacher->id == $request->user()->id)){
            return response()->json([
                'message'=>"Вы не ведете предмет \"$targetSubject->name\""
            ],403);
        }

        //TODO Рефактор более простым методом (уверен он есть)
        $contains = collect($user->group->subjects)->pluck('id')->filter(function ($item) use ($targetSubject) {return $targetSubject->id == $item;})->values();
        //Проверка на то что такой предмет вообще преподается у ученика
        if($contains->isEmpty()){
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

    /**
     * @param Request $request
     * @param Group $group
     * @return JsonResponse
     * @throws ValidationException
     */
    public function groupGrades(Request $request,Group $group): JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            //TODO За все время
            'semester_id' => 'required|integer|exists:semesters,id',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        /** @var Subject $targetSubject */
        $targetSubject = Subject::find($validatedData['subject_id']);
        if(!($targetSubject->teacher->id == $request->user()->id)){
            return response()->json([
                'message'=>"Вы не ведете предмет \"$targetSubject->name\""
            ],403);
        }


        if(!($group->teacherTeachThisGroup($request->user()->id))){
            return response()->json([
                'message'=>"Вы не ведете предметы у группы \"$group->name\""
            ],403);
        }

        //TODO возможно понадобится вынести в ресурс
        /** @var Semester $semester */
        $semester = Semester::find($validatedData['semester_id']);
        unset($semester['from']);
        unset($semester['to']);

        $students = $group->grades()
            ->where('semester_id', $validatedData['semester_id'])
            ->where('subject_id', $validatedData['subject_id'])
            ->get()
            ->groupBy(['user_id'])
            ->map(function ($items){
                /** @var User $user */
                $user = User::find($items[0]->user_id);
                return [
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'surname'=>$user->surname,
                    'patronymic'=>$user->patronymic,
                    'grades'=>DetailedMiniGradeResource::collection($items),
                ];
            })->values();
        return response()->json([
            'semester'=>$semester,
            'students'=>$students,
        ]);
    }

    /**
     * Edit student`s grade
     * @param EditGradeRequest $request
     * @param Grade $grade
     * @return JsonResponse
     */
    public function edit(EditGradeRequest $request,Grade $grade): JsonResponse
    {
        //TODO проверка на одинаковые данные с фронта
        $validatedData = $request->validated();
        /** @var Work $work */
        $subject = $grade->subject;
        if(array_key_exists('work_id',$validatedData)&& $validatedData['work_id']!=null){
            $work = Work::find($validatedData['work_id']);
            if (!($work->subject->name===$grade->subject->name)){
                return response()->json([
                    'message'=>"Тема \"$work->theme\" не относится к предмету \"$subject->name\""
                ],403);
            }
        }
        $initials = $subject->teacher->initials();

        /** @var Collection $teacherSubjects */
        $teacherSubjects = $request->user()->subjects->map(function ($item){
            return $item->name;
        });

        //Нельзя поменять оценку, если предмет оценки ведет не текущий препод, так же интерпретируется как ошибка, если пытаемся поменять оценку по этом уже предмету, но оценку выставил другой преподаватель

        $adSection =$teacherSubjects->contains($subject->name)?" или оценку выставили не вы ($initials)":"";
        if(!($subject->teacher->id==$request->user()->id)){
            return response()->json([
                'message'=>"Вы не можете изменить эту оценку, так как вы не ведете предмет \"$subject->name\"".$adSection
            ],403);
        }
        $grade->fill($validatedData);

        return response()->json([
            'success'=>true,
            'message'=>"Оценка успешно изменена!"
        ]);
    }
}
