<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    function Quiz($ClassLink){
        $Class=course::where('ClassLink',$ClassLink)->first();
        return view('student.StudentQuiz',[
            'ClassLink'=> $ClassLink,
        ]);
    }
    function InputName($ClassLink){
        $Class=course::where('ClassLink',$ClassLink)->first();
        $Name=request('name');
        student::create([
            'classID'=>$Class->ClassLink,
            'name'=>$Name,
        ]);
        return view('student.Question');
    }
    function StudentIndex($ClassLink){

    }
}
