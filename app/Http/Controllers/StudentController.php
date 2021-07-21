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
use RealRashid\SweetAlert\Facades\Alert;

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
            'OthersCount'=>0,
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
        if(\request('answer')==null)
        {
            Alert::warning('未選擇答案');
            return back();
        }
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
        if(\request('answer')==null)
        {
            Alert::warning('未選擇答案');
            return back();
        }
        answer::updateOrCreate(
            ['otherID'=>$Oid , 'questionID'=>$Qid],
            ['answer'=>request('answer')]
        );
        $Qid++;
        if($Qid<=24){
            return \Redirect::route('student.OthersQuestion',['Sid' => $Sid,'Oid'=>$Oid,'Qid'=>$Qid]);
        }
        else
            $student=student::find($Sid);
            $student->update(['OthersCount'=>$student->OthersCount+1]);
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
        $questions=[];
        for ($i=1;$i<=12;$i++)
        {
            $questions+=question::find($i);
        }
        dd($questions);
        $S1=0;$S2=0;$S3=0;$S4=0;
        foreach ($answers as $answer){
            if($answer->answer=='A'){
                $S1=$S1+1;
            }
            if ($answer->answer=='B'){
                $S2=$S2+1;
            }
            if ($answer->answer=='C'){
                $S3=$S3+1;
            }
            if ($answer->answer=='D'){
                $S4=$S4+1;
            }
        }
        $img = Image::make(public_path('page1.jpg'));
        $img->text($student->name, 1340, 540, function($font) {
            $font->file(public_path('font.ttf'));
            $font->size(72);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S1, 665, 1500, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 665, 1390, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 550, 1390, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 550, 1500, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $Oids=other::where('studentID',$Sid)->pluck('id');
        $S1=0;$S2=0;$S3=0;$S4=0;$count=0;
        foreach ($Oids as $Oid){
            $answers=answer::where('otherID',$Oid)->get();
            foreach ($answers as $answer){
                $count=$count+1;
                if($answer->answer=='A'){
                    $S1=$S1+1;
                }
                if ($answer->answer=='B'){
                    $S2=$S2+1;
                }
                if ($answer->answer=='C'){
                    $S3=$S3+1;
                }
                if ($answer->answer=='D'){
                    $S4=$S4+1;
                }
            }
        }
        $count=floor($count/12);
        $S1=round($S1/$count);$S2=round($S2/$count);$S3=round($S3/$count);$S4=round($S4/$count);
        $img->text($S1, 1825, 1490, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 1825, 1380, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 1710, 1380, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 1710, 1490, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        return($img->response('jpg'));
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
        $img = Image::make(public_path('page2.jpg'));
        $img->text($S1, 645, 1815, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 755, 1815, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 865, 1815, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 975, 1815, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum, 975, 1925, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(48);
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
        $img->text($S1, 1375, 1790, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 1485, 1790, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 1595, 1790, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 1705, 1790, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum, 1705, 1900, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(48);
            $font->align('center');
            $font->valign('top');
        });
        return($img->response('jpg'));
    }
    function MakeChart3($Sid){
        $img = Image::make(public_path('page3.jpg'));
        $Oids=other::where('studentID',$Sid)->pluck('id');
        $S1=0;$S2=0;$S3=0;$S4=0;
        $R1S1=0;$R1S2=0;$R1S3=0;$R1S4=0;
        $R2S1=0;$R2S2=0;$R2S3=0;$R2S4=0;
        $R3S1=0;$R3S2=0;$R3S3=0;$R3S4=0;
        $R4S1=0;$R4S2=0;$R4S3=0;$R4S4=0;
        foreach ($Oids as $Oid){
            $answers=answer::where('otherID',$Oid)->get();
            foreach ($answers as $answer){
                if($answer->answer=='A'){
                    $S1=$S1+1;
                    if($answer->questionID==13 || $answer->questionID==17 || $answer->questionID==21){
                        $R1S1=$R1S1+1;
                    }
                    if($answer->questionID==14 || $answer->questionID==18 || $answer->questionID==22){
                        $R2S1=$R2S1+1;
                    }
                    if($answer->questionID==15 || $answer->questionID==19 || $answer->questionID==23){
                        $R3S1=$R3S1+1;
                    }
                    if($answer->questionID==16 || $answer->questionID==20 || $answer->questionID==24){
                        $R4S1=$R4S1+1;
                    }
                }
                if ($answer->answer=='B'){
                    $S2=$S2+1;
                    if($answer->questionID==13 || $answer->questionID==17 || $answer->questionID==21){
                        $R1S2=$R1S2+1;
                    }
                    if($answer->questionID==14 || $answer->questionID==18 || $answer->questionID==22){
                        $R2S2=$R2S2+1;
                    }
                    if($answer->questionID==15 || $answer->questionID==19 || $answer->questionID==23){
                        $R3S2=$R3S2+1;
                    }
                    if($answer->questionID==16 || $answer->questionID==20 || $answer->questionID==24){
                        $R4S2=$R4S2+1;
                    }
                }
                if ($answer->answer=='C'){
                    $S3=$S3+1;
                    if($answer->questionID==13 || $answer->questionID==17 || $answer->questionID==21){
                        $R1S3=$R1S3+1;
                    }
                    if($answer->questionID==14 || $answer->questionID==18 || $answer->questionID==22){
                        $R2S3 = $R2S3 + 1;
                    }
                    if($answer->questionID==15 || $answer->questionID==19 || $answer->questionID==23){
                        $R3S3=$R3S3+1;
                    }
                    if($answer->questionID==16 || $answer->questionID==20 || $answer->questionID==24){
                        $R4S3=$R4S3+1;
                    }
                }
                if ($answer->answer=='D'){
                    $S4=$S4+1;
                    if($answer->questionID==13 || $answer->questionID==17 || $answer->questionID==21){
                        $R1S4=$R1S4+1;
                    }
                    if($answer->questionID==14 || $answer->questionID==18 || $answer->questionID==22){
                        $R2S4=$R2S4+1;
                    }
                    if($answer->questionID==15 || $answer->questionID==19 || $answer->questionID==23){
                        $R3S4=$R3S4+1;
                    }
                    if($answer->questionID==16 || $answer->questionID==20 || $answer->questionID==24){
                        $R4S4=$R4S4+1;
                    }
                }
            }
        }
        $OverLead=$R4S1+$R3S1+$R2S1+$R4S2+$R3S2+$R4S3;
        $LessLead=$R3S4+$R2S4+$R1S4+$R2S3+$R1S3+$R1S2;
        $sum=$S1+$S2+$S3+$S4;
        $sum2=$R4S4+$R3S3+$R2S2+$R1S1;
        $result=round($sum2/$sum, 2)*100;
        $result = (string)$result;
        $result= $result . "%";
        $img->text($S1, 630, 1725, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S2, 630, 1510, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S3, 630, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S4, 630, 1080, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R1S1, 1610, 1725, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R1S2, 1610, 1510, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R1S3, 1610, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R1S4, 1610, 1080, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R2S1, 1365, 1725, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R2S2, 1365, 1510, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R2S3, 1365, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R2S4, 1365, 1080, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R3S1, 1120, 1725, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R3S2, 1120, 1510, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R3S3, 1120, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R3S4, 1120, 1080, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R4S1, 875, 1725, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R4S2, 875, 1510, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R4S3, 875, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($R4S4, 875, 1080, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($OverLead, 415, 1295, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
            $font->angle(90);
        });
        $img->text($LessLead, 1790, 1075, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(36);
            $font->align('center');
            $font->valign('top');
            $font->angle(90);
        });
        $img->text($sum, 355, 2175, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(48);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($sum2, 885, 2175, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(48);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($result, 885, 2290, function($font) {
            $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
            $font->size(48);
            $font->align('center');
            $font->valign('top');
        });
        return($img->response('jpg'));
    }
    public function logo(){
        $img = Image::make(public_path('logo.png'));
        return($img->response('png'));
    }
}
