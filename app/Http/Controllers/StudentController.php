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
        $Student=student::find($Sid);
        answer::updateOrCreate(
            ['studentID'=>$Sid , 'questionID'=>$Qid],
            ['answer'=>request('answer')]
        );
        $Qid++;
        if($Qid<=12){
        return \Redirect::route('student.Question',['Sid' => $Student->id,'Qid'=>$Qid]);
        }
        else
            return view('student.FinishQuiz',['Sid' => $Student->id]);
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
        $answers=answer::where('studentID',$Sid)->get();
        $S1=0;$S2=0;$S3=0;$S4=0;
        foreach ($answers as $answer){
            $weight=question::find($answer->questionID);
            if($answer->answer=='A'){
                $S1=$S1+$weight->S1;
            }
            if ($answer->answer=='B'){
                $S2=$S2+$weight->S2;
            }
            if ($answer->answer=='C'){
                $S3=$S3+$weight->S3;
            }
            if ($answer->answer=='D'){
                $S4=$S4+$weight->S4;
            }
        }
        $sum=$S1+$S2+$S3+$S4;

        $img = Image::make(public_path('Chart1.png'));
        $img->text($S1, 420, 1260, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 560, 1260, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 690, 1260, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 830, 1260, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum, 830, 1400, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        return $img->response('png');
    }
    function OthersQuiz($Sid){
        $student=student::find($Sid);
        return view('student.OthersQuiz',[
            'student'=> $student,
        ]);
    }
}
