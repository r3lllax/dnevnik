<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

abstract class Controller
{
    //
    protected function validateQuery($query,$rules){
        $validator = Validator::make($query,$rules);
        $fail = null;
        if($validator->fails()){
            $fail = [
                'errors' => $validator->errors()
            ];
        }
        return [$validator->validated(),$fail];
    }
}
