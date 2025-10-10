<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateWorkRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type_id' => 'required|integer|exists:works_types,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'theme'=>'required|string|max:255',
            'date'=>'required|date|date_format:Y-m-d|before_or_equal:today',
        ];
    }
}
