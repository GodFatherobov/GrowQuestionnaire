<?php

namespace App\Http\Controllers;

use App\Models\course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    function Quiz($ClassLink){
        $Class=course::where('ClassLink',$ClassLink)->first();
        dd($Class);
        return view('student.StudentQuiz');
    }
}
