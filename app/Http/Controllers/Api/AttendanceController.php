<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceDatesHeadmanResource;
use App\Http\Resources\AttendanceDatesResource;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    /**
     * Group attendance for teacher
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function show(Request $request): JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            'group_id' => 'required|integer|exists:groups,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'month' => 'required|integer|between:1,12',
        ]);

        $targetMonth = Carbon::createFromFormat('m', $validatedData['month'])->format('F');

        /** @var Semester $targetSemester */
        $targetSemester = Semester::find($validatedData['semester_id']);
        if(!($targetSemester->monthInSemester((int)$validatedData['month']))){
            return response()->json([
                //TODO Тут неправильная локализация, фиксить сменой локали всего приложения
                'message'=>"Ошибка. Месяц \"$targetMonth\" не входит в \"$targetSemester->name\" ($targetSemester->from - $targetSemester->to)"
            ],403);
        }

        /** @var Subject $targetSubject */
        $targetSubject = Subject::query()->find($validatedData['subject_id']);
        $teacherSubjects = $request->user()->subjects->map(function ($subject){
            return $subject->name;
        })->values();

        $targetTeacher = $targetSubject->teacher->initials();
        $anotherTeacherMessage = $teacherSubjects->contains($targetSubject->name)?" так как его ведет \"$targetTeacher\" ":"";

        if ($targetSubject->teacher->id!=$request->user()->id){
            return response()->json([
                'message'=>"Ошибка доступа. Вы не можете смотреть посещаемость за предмет \"$targetSubject->name\"".$anotherTeacherMessage . ".",
            ],403);
        }

        /** @var Group $targetGroup */
        $targetGroup = Group::query()->find($validatedData['group_id']);

        $teacherTeachThisSubjectForThisGroup = $targetGroup->subjects->map(function ($subject){
            return $subject->id;
        })->values()->contains($targetSubject->id);

        if (!$teacherTeachThisSubjectForThisGroup){
            return response()->json([
                'message'=>"Ошибка доступа. Вы не ведете предмет \"$targetSubject->name\" у группы $targetGroup->name.",
            ],403);
        }
        $attendance = Attendance::query()
            ->join('users', 'users.id', '=', 'attendance.user_id')
            ->join('groups', 'groups.id', '=', 'users.group_id')
            ->join('schedule', 'schedule_id', '=', 'schedule.id')
            ->where('users.group_id', $validatedData['group_id'])
            ->where('schedule.semester_id', $validatedData['semester_id'])
            ->where('schedule.subject_id', $validatedData['subject_id'])
            ->get()
            ->filter(function ($item) use ($validatedData) {
                return Carbon::parse($item->date)->month===(int)$validatedData['month'];
            });

        $formatedAttendance = $attendance
            ->groupBy(['user_id'])
            ->map(function ($item, $key) {
                /** @var User $user */
                $user = User::query()->find($key);
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'patronymic' => $user->patronymic,
                    'dates'=>AttendanceDatesResource::collection($item),
                ];
            })->values();


        return response()->json([
            'subject_name'=>$targetSubject->name,
            'students'=>$formatedAttendance,
        ]);
    }

    /**
     * Group attendance for headman
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        [$validatedData] = $this->validateQuery($request->query(),[
            'semester_id' => 'required|integer|exists:semesters,id',
            'month' => 'required|integer|between:1,12',
        ]);

        $targetMonth = Carbon::createFromFormat('m', $validatedData['month'])->format('F');

        /** @var Semester $targetSemester */
        $targetSemester = Semester::find($validatedData['semester_id']);
        if(!($targetSemester->monthInSemester((int)$validatedData['month']))){
            return response()->json([
                'message'=>"Ошибка. Месяц \"$targetMonth\" не входит в \"$targetSemester->name\" ($targetSemester->from - $targetSemester->to)"
            ],403);
        }

        $attendance = Attendance::query()
            ->join('users', 'users.id', '=', 'attendance.user_id')
            ->join('groups', 'groups.id', '=', 'users.group_id')
            ->join('schedule', 'schedule_id', '=', 'schedule.id')
            ->where('users.group_id', $request->user()->group_id)
            ->where('schedule.semester_id', $validatedData['semester_id'])
            ->get()
            ->filter(function ($item) use ($validatedData) {
                return Carbon::parse($item->date)->month===(int)$validatedData['month'];
            });
        $formatedAttendance = $attendance
            ->groupBy(['user_id'])
            ->map(function ($item, $key) {
                /** @var User $user */
                $user = User::query()->find($key);
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'patronymic' => $user->patronymic,
                    'dates'=>AttendanceDatesHeadmanResource::collection($item),
                    'stats'=>[
                        'reasonable'=>$item->filter(function ($i){
                            return $i->reasonable==true && $i->passed_hours>0;
                        })->count(),
                        'unreasonable'=>$item->filter(function ($i){
                            return $i->reasonable==false && $i->passed_hours>0;
                        })->count(),
                        'all_hours'=>collect($item)->sum('passed_hours'),
                    ]
                ];
            })->values();


        return response()->json([
            'students'=>$formatedAttendance,
        ]);
    }

    public function create()
    {
        $students = [
            0=>[
                'id'=>1, //
                'hours'=>true,
                'schedule_id'=>1, //Такой предмет должен быть в расписании пользователя
                //За такой предмет не должна быть выставлена посещаемость
                'present'=>false,
                'reason'=>'Reason',
                'reasonable'=>false,
            ]
        ];
    }
}

