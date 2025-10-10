<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGradeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject_id'=>'required|integer|exists:subjects,id',
            'work_id'=>'nullable|integer|exists:works,id',
            'grade'=>'required|integer|min:1|max:5', //TODO Возможно вынести n-бальную систему оценивания (ведь не всегда 1-5, а например 1-12, или A-F)
            'comment'=>'nullable|string|max:255',
            'semester_id'=>'nullable|integer|exists:semesters,id',
        ];
    }
}
