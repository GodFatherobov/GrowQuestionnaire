<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    function Question(){
        return view('student.StudentQuiz');
    }
}
