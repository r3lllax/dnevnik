<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

abstract class Controller
{
    /**
     * Query validation helper
     * @param $query
     * @param $rules
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateQuery($query,$rules): array
    {
        $validator = Validator::make($query,$rules);
        $fail = null;
        if($validator->fails()){
            $fail = [
                'errors' => $validator->errors()
            ];
        }
        return [$validator->validated(),$fail];
    }


    /**
     * @return array
     */
    protected function getCurrentSemester(): array
    {
        /** @var Semester[] $semesters */
        $semesters = Semester::all();
        $index = 0;
        foreach($semesters as $item){
            $now = Carbon::now();
            $start = Carbon::parse($item->from);
            $end = Carbon::parse($item->to);
            if ($now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end)) {
                break;
            }
            $index++;
        }
        return [$semesters,$index];
    }
}
