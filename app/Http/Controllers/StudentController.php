<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\question;
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
        $Name=request('Name');
        $Student=student::create([
            'classID'=>$Class->id,
            'name'=>$Name,
        ]);
        return \Redirect::route('student.Question',['Sid' => $Student->id,'Qid'=>1]);
    }
    function ShowQuestion($Sid,$Qid){
        $question=question::find($Qid);
        return view('student.Question',[
            'question'=>$question,
        ]);
    }
}
