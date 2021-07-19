<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\course;
use App\Models\other;
use App\Models\question;
use App\Models\student;
use PDF;
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
        $Student=student::firstOrCreate([
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
        answer::updateOrCreate(
            ['studentID'=>$Sid , 'questionID'=>$Qid],
            ['answer'=>request('answer')]
        );
        $Qid++;
        if($Qid<=12){
        return \Redirect::route('student.Question',['Sid' => $Sid,'Qid'=>$Qid]);
        }
        else
            return view('student.FinishQuiz',['Sid' => $Sid]);
    }
    function StudentShow($Sid){
        $student=student::find($Sid);
        $answers=answer::where('studentID',$Sid)->get();
        return view('student.StudentShow',[
            'student'=> $student,
            'answers'=> $answers,
        ]);
    }
    function OthersQuiz($Sid){
        $student=student::find($Sid);
        return view('student.OtherQuiz',[
            'student'=> $student,
        ]);
    }
    function InputType($Sid){
        $other=other::create([
            'studentID'=>$Sid,
            'type'=>request('type'),
        ]);
        return \Redirect::route('student.OthersQuestion',['Sid' => $Sid,'Oid'=>$other->id,'Qid'=>13]);
    }
    function ShowOtherQuestion($Sid,$Oid,$Qid){
        $question=question::find($Qid);
        return view('student.OtherQuestion',[
            'question'=>$question,
            'Qid'=>$Qid,
            'Sid'=>$Sid,
            'Oid'=>$Oid,
        ]);
    }
    function StoreOtherAnswer($Sid,$Oid,$Qid){
        answer::updateOrCreate(
            ['otherID'=>$Oid , 'questionID'=>$Qid],
            ['answer'=>request('answer')]
        );
        $Qid++;
        if($Qid<=24){
            return \Redirect::route('student.OthersQuestion',['Sid' => $Sid,'Oid'=>$Oid,'Qid'=>$Qid]);
        }
        else
            return('感謝您的填寫 !');
    }
    function OtherIndex($Sid){
        $student=student::find($Sid);
        $others=other::where('studentID',$Sid)->get();
        return view('student.OtherIndex',[
            'others'=> $others,
            'student'=>$student,
        ]);
    }
    function OtherShow($Oid){
        $other=student::find($Oid);
        $answers=answer::where('otherID',$Oid)->get();
        return view('student.OtherShow',[
            'other'=> $other,
            'answers'=> $answers,
        ]);
    }
    function Chart($Sid){
        $pdf = PDF::loadView('student.output_pdf',['Sid' => $Sid]);
        $pdf->setPaper('A4');
        return $pdf->stream();
    }
    function MakeChart1($Sid){
        $student=student::find($Sid);
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
        $img = Image::make(public_path('page1.png'));
        $img->text($student->name, 418, 169, function($font) {
            $font->file(public_path('font.ttf'));
            $font->size(14);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S1, 210, 458, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 210, 424, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 173, 424, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 173, 458, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $Oids=other::where('studentID',$Sid)->pluck('id');
        $S1=0;$S2=0;$S3=0;$S4=0;$count=0;
        foreach ($Oids as $Oid){
            $count=$count+1;
            $answers=answer::where('otherID',$Oid)->get();
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
        }
        $S1=round($S1/$count);$S2=round($S2/$count);$S3=round($S3/$count);$S4=round($S4/$count);
        $img->text($S1, 542, 455, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 542, 421, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 577, 421, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 577, 455, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        return($img->response('png'));
    }
    function MakeChart2($Sid){
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
        $img = Image::make(public_path('page2.png'));
        $img->text($S1, 204, 575, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 240, 575, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 276, 575, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 312, 575, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum, 312, 610, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $Oids=other::where('studentID',$Sid)->pluck('id');
        $S1=0;$S2=0;$S3=0;$S4=0;$count=0;
        foreach ($Oids as $Oid){
            $count=$count+1;
            $answers=answer::where('otherID',$Oid)->get();
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
        }
        $S1=round($S1/$count);$S2=round($S2/$count);$S3=round($S3/$count);$S4=round($S4/$count);
        $sum=round($S1+$S2+$S3+$S4);
        $img->text($S1, 435, 567, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 470, 567, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 505, 567, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 540, 567, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum, 540, 602, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        return($img->response('png'));
    }
    function MakeChart3($Sid){

        $img = Image::make(public_path('page3.png'));
        $Oids=other::where('studentID',$Sid)->pluck('id');
        $S1=0;$S2=0;$S3=0;$S4=0;
        $R1S1=0;$R1S2=0;$R1S3=0;$R1S4=0;
        $R2S1=0;$R2S2=0;$R2S3=0;$R2S4=0;
        $R3S1=0;$R3S2=0;$R3S3=0;$R3S4=0;
        $R4S1=0;$R4S2=0;$R4S3=0;$R4S4=0;
        foreach ($Oids as $Oid){
            $answers=answer::where('otherID',$Oid)->get();
            foreach ($answers as $answer){
                $weight=question::find($answer->questionID);
                if($answer->answer=='A'){
                    $S1=$S1+$weight->S1;
                    if($answer->questionID==1 || $answer->questionID==5 || $answer->questionID==9){
                        $R1S1=$R1S1+1;
                    }
                    if($answer->questionID==2 || $answer->questionID==6 || $answer->questionID==10){
                        $R2S1=$R2S1+1;
                    }
                    if($answer->questionID==3 || $answer->questionID==7 || $answer->questionID==11){
                        $R3S1=$R3S1+1;
                    }
                    if($answer->questionID==4 || $answer->questionID==8 || $answer->questionID==12){
                        $R4S1=$R4S1+1;
                    }
                }
                if ($answer->answer=='B'){
                    $S2=$S2+$weight->S2;
                    if($answer->questionID==1 || $answer->questionID==5 || $answer->questionID==9){
                        $R1S2=$R1S2+1;
                    }
                    if($answer->questionID==2 || $answer->questionID==6 || $answer->questionID==10){
                        $R2S2=$R2S2+1;
                    }
                    if($answer->questionID==3 || $answer->questionID==7 || $answer->questionID==11){
                        $R3S2=$R3S2+1;
                    }
                    if($answer->questionID==4 || $answer->questionID==8 || $answer->questionID==12){
                        $R4S2=$R4S2+1;
                    }
                }
                if ($answer->answer=='C'){
                    $S3=$S3+$weight->S3;
                    if($answer->questionID==1 || $answer->questionID==5 || $answer->questionID==9){
                        $R1S3=$R1S3+1;
                    }
                    if($answer->questionID==2 || $answer->questionID==6 || $answer->questionID==10) {
                        $R2S3 = $R2S3 + 1;
                    }
                    if($answer->questionID==3 || $answer->questionID==7 || $answer->questionID==11){
                        $R3S3=$R3S3+1;
                    }
                    if($answer->questionID==4 || $answer->questionID==8 || $answer->questionID==12){
                        $R4S3=$R4S3+1;
                    }
                }
                if ($answer->answer=='D'){
                    $S4=$S4+$weight->S4;
                    if($answer->questionID==1 || $answer->questionID==5 || $answer->questionID==9){
                        $R1S4=$R1S4+1;
                    }
                    if($answer->questionID==2 || $answer->questionID==6 || $answer->questionID==10){
                        $R2S4=$R2S4+1;
                    }
                    if($answer->questionID==3 || $answer->questionID==7 || $answer->questionID==11){
                        $R3S4=$R3S4+1;
                    }
                    if($answer->questionID==4 || $answer->questionID==8 || $answer->questionID==12){
                        $R4S4=$R4S4+1;
                    }
                }
            }
        }
        $img->text($S1, 197, 552, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 197, 483, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 197, 417, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 197, 351, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R1S1, 503, 554, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(12);
            $font->align('center');
            $font->valign('top');
        });

        return($img->response('png'));
    }
}
