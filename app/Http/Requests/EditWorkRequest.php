<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditWorkRequest extends FormRequest
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
            'theme'=>'required|string|max:255',
            'date'=>'required|date|date_format:Y-m-d|after_or_equal:today',
        ];
    }
}
