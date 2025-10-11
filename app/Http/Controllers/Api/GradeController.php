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
        }
        return response()->json([
            'message'=>'Ошибка доступа.'
        ],403);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            'semester_id' => 'required|integer|exists:semesters,id',
        ]);

        /** @var User $user */
        $user = $request->user();
        $data = collect($user
            ->grades()
            ->join('subjects','grades.subject_id','=','subjects.id')
            ->where('semester_id', $validatedData['semester_id'])
            ->get()
            ->groupBy(['name',function ($item) {
            return $item->work_id === null ? 'advanced_grades' : 'main_grades';
        }]))
            ->map(function ($items,$subject_name) {

            /** @var Subject $subject */
            $allGrades =collect($items)->collapse()->map(function ($item) {
                return (int)$item->grade;
            })->values();
            $avgGrade = $allGrades->count()>0?array_sum($allGrades->toArray())/$allGrades->count():0;
            return [
                'subject'=>$subject_name,
                'avg'=>round($avgGrade,2),
                'main_grades'=>MiniGradeResource::collection($items['main_grades']),
                'advanced_grades'=>array_key_exists('advanced_grades', $items->toArray())?MiniGradeResource::collection($items['advanced_grades']):[],
            ];
        })->values();
        //Привожу к тому же виду для поиска отсутсвующих предметов
        $compareResponse = $data->map(function ($item){
           return[
               $item['subject'],
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
                    'subject'=>$subj->name,
                    'avg'=>0,
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
        if ($user->role->name!="Студент" && $user->role->name!="Староста"){
            return response()->json([
                'message'=>'Данный пользователь не является учеником'
            ],403);
        }

        $initials = $user->initials();



        /** @var Subject $targetSubject */
        $targetSubject = Subject::find($validatedData['subject_id']);

        //Проверка что преподаватель вообще ведет этот предмет
        $reqUserSubjects = $request->user()->subjects->map(function ($item,$key){
            return $item->name;
        })->values();
        if (!($reqUserSubjects->contains($targetSubject->name))){
            return response()->json([
                'message'=>"Вы не ведете предмет \"$targetSubject->name\""
            ],403);
        }

        if(array_key_exists('work_id',$validatedData)){
            $work = Work::find($validatedData['work_id']);
            if(!($work->subject->name===$targetSubject->name)){
                return response()->json([
                    'message'=>"Тема \"$work->theme\" не относится к предмету \"$targetSubject->name\""
                ],403);
            }
        }

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
        $sub = Subject::query()->find($validatedData['subject_id'])->name;
        $ids = Subject::query()->where('name',$sub)->get()->map(function ($item){
            return $item->id;
        })->values()->toArray();


        $students = $group
            ->grades()
            ->join('subjects','grades.subject_id','=','subjects.id')
            ->where('semester_id', $validatedData['semester_id'])
            ->whereIn('subject_id', $ids)
            ->get()
            ->groupBy(['user_id'])
            ->map(function ($items){
                /** @var User $user */
                $user = User::find($items[0]->user_id);
                $allGrades = $items->map(function ($item){
                    return (int)$item->grade;
                })->values();
                $avgGrade = array_sum($allGrades->toArray())/$allGrades->count();

                return [
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'surname'=>$user->surname,
                    'patronymic'=>$user->patronymic,
                    'avg'=>round($avgGrade,2),
                    'grades'=>DetailedMiniGradeResource::collection($items),
                ];
            })->values();

        $existsCompare = $students->map(function ($student){
            return $student['id'];
        })->values();

        $allExists = $group->users->map(function ($user){
            return $user->id;
        })->values();

        foreach ($allExists->diff($existsCompare)->values() as $item){
            /** @var User $stud */
            $stud = User::find($item);
            $students[]=[
                'id'=>$stud->id,
                'name'=>$stud->name,
                'surname'=>$stud->surname,
                'patronymic'=>$stud->patronymic,
                'avg'=>0,
                'grades'=>[],
            ];
        }
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
