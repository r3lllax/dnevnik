<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Http\Resources\MiniGradeResource;
use App\Models\Grade;
use App\Models\Schedule;
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
     * returns student grades for semester
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        //TODO Вынести валидацию в метод конревого контроллера (например Validate([data_array],[rules]), возвращает [$validatedData,$errorResponse(не факт, посмотреть как сделал в прошлоый работе)])
        $semester_id = $request->get('semester_id');
        $validator = Validator::make($request->query(), [
            'semester_id' => 'required|integer|exists:semesters,id',
        ]);
        if ($validator->fails()){
            return response()->json([
                'message'=>'validation error',
                'errors'=>$validator->errors()
            ]);
        }

        /** @var User $user */
        $user = $request->user();
        $data = collect($user->grades()->where('semester_id', $semester_id)->get()->groupBy(['subject_id',function ($item) {
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

        // TODO Проверка наличия всех предметов ответе
        //Перед отрпавкой добавлять добавлять пустые предметы, так как сейчас отправляются только те, за которые получена хотя бы одна ошибка
        //То есть брать список предметов у группы студента, и проверять есть ли записи о них в ответе, если нет, то добавлять пустой объект с этим объекм вида
        //{
        //  id:ID,
        //  name:NAME,
        //  main_grades:[],
        //  advanced_grades:[]
        //}
        //Чтобы на фронте при просмотре оценок отрисовывались все предметы

        return response()->json(['subjects'=>$data]);

    }
}
