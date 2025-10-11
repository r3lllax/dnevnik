<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditGradeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'work_id'=>'nullable|integer|exists:works,id',
            'grade'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string|max:255',
            'semester_id'=>'required|integer|exists:semesters,id',//TODO узнать про обязательное поле при изменении или нет
        ];
    }
}
