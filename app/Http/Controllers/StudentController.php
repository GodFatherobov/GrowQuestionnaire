<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\course;
use App\Models\question;
use App\Models\student;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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
            'Qid'=>$Qid,
            'Sid'=>$Sid,
        ]);
    }
    function StoreAnswer($Sid,$Qid){
        answer::create([
            'studentID'=>$Sid,
            'questionID'=>$Qid,
            'answer'=>request('answer'),
        ]);
        $Qid++;
        if($Qid<=12){
        $Student=student::find($Sid);
        return \Redirect::route('student.Question',['Sid' => $Student->id,'Qid'=>$Qid]);
        }
        else
            return ('作答完成');
    }
    function StudentShow($Sid){
        $student=student::find($Sid);
        $answers=answer::where('studentID',$Sid)->get();
        return view('student.StudentShow',[
            'student'=> $student,
            'answers'=> $answers,
        ]);
    }
    function MakeChart($Sid){
        $img = Image::make(public_path('public/Chart1.png'));
        return $img->response('png');

    }
}
