<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        [$semesters,$index] = $this->getCurrentSemester();
        $otherSemesters = $semesters->toArray();
        unset($otherSemesters[$index]);
        return response()->json([
            'semesters' => [
                'current' => $semesters[$index],
                'other'=>array_values($otherSemesters)
            ]
        ]);
    }
}
