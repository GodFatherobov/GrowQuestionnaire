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
    // ──────────────────────────────────────────────
    //  Demo session helpers
    // ──────────────────────────────────────────────

    private function isDemoSid($Sid): bool
    {
        return (string) $Sid === 'demo';
    }

    private function isDemoOid($Oid): bool
    {
        return str_starts_with((string) $Oid, 'demo_');
    }

    private function demoOidIndex($Oid): int
    {
        return (int) str_replace('demo_', '', (string) $Oid);
    }

    // ──────────────────────────────────────────────
    //  Self-assessment (自評) routes
    // ──────────────────────────────────────────────

    function Quiz($ClassLink)
    {
        $Class = course::where('ClassLink', $ClassLink)->firstOrFail();
        return view('student.StudentQuiz', [
            'ClassLink' => $ClassLink,
            'class'     => $Class,
            'isDemo'    => $Class->ClassLink === 'demo',
        ]);
    }

    function InputName($ClassLink)
    {
        $Class = course::where('ClassLink', $ClassLink)->firstOrFail();

        if ($Class->ClassLink === 'demo') {
            session(['demo_mode' => [
                'name'    => request('Name'),
                'classID' => $Class->id,
                'answers' => [],
                'others'  => [],
            ]]);
            return redirect()->route('student.ResumeQuiz', ['Sid' => 'demo']);
        }

        $Student = student::firstOrCreate(
            ['classID' => $Class->id, 'name' => request('Name')],
            ['OthersCount' => 0]
        );
        return redirect()->route('student.ResumeQuiz', ['Sid' => $Student->id]);
    }

    function resumeQuiz($Sid)
    {
        if ($this->isDemoSid($Sid)) {
            $answers = session('demo_mode.answers', []);
            $count   = count($answers);
            if ($count == 0) {
                return redirect()->route('student.Question', ['Sid' => 'demo', 'Qid' => 1]);
            }
            if ($count >= 12) {
                return redirect()->route('student.Question', ['Sid' => 'demo', 'Qid' => 12]);
            }
            $nextQid = max(array_keys($answers)) + 1;
            return redirect()->route('student.Question', ['Sid' => 'demo', 'Qid' => $nextQid]);
        }

        $count = answer::where('studentID', $Sid)->whereNull('otherID')->count();
        if ($count == 0) {
            return redirect()->route('student.Question', ['Sid' => $Sid, 'Qid' => 1]);
        }
        if ($count >= 12) {
            return redirect()->route('student.Question', ['Sid' => $Sid, 'Qid' => 12]);
        }
        $nextQid = answer::where('studentID', $Sid)->whereNull('otherID')->max('questionID') + 1;
        return redirect()->route('student.Question', ['Sid' => $Sid, 'Qid' => $nextQid]);
    }

    function ShowQuestion($Sid, $Qid)
    {
        if ($Qid < 1 || $Qid > 12) abort(404);
        $question = question::findOrFail($Qid);

        if ($this->isDemoSid($Sid)) {
            $currentAnswer = session('demo_mode.answers.' . $Qid);
            return view('student.Question', [
                'question'      => $question,
                'Qid'           => $Qid,
                'Sid'           => 'demo',
                'currentAnswer' => $currentAnswer,
                'isDemo'        => true,
            ]);
        }

        $currentAnswer = answer::where('studentID', $Sid)
            ->where('questionID', $Qid)
            ->whereNull('otherID')
            ->value('answer');
        return view('student.Question', [
            'question'      => $question,
            'Qid'           => $Qid,
            'Sid'           => $Sid,
            'currentAnswer' => $currentAnswer,
            'isDemo'        => false,
        ]);
    }

    function StoreAnswer($Sid, $Qid)
    {
        if (request('answer') == null) {
            Alert::warning('未選擇答案');
            return back();
        }

        if ($this->isDemoSid($Sid)) {
            session(['demo_mode.answers.' . $Qid => request('answer')]);
            if ($Qid < 12) {
                return redirect()->route('student.ResumeQuiz', ['Sid' => 'demo']);
            }
            return view('student.FinishQuiz', ['Sid' => 'demo', 'isDemo' => true]);
        }

        answer::updateOrCreate(
            ['studentID' => $Sid, 'questionID' => $Qid, 'otherID' => null],
            ['answer' => request('answer')]
        );
        if ($Qid < 12) {
            return redirect()->route('student.ResumeQuiz', ['Sid' => $Sid]);
        }
        return view('student.FinishQuiz', ['Sid' => $Sid, 'isDemo' => false]);
    }

    function StudentShow($Sid)
    {
        if ($this->isDemoSid($Sid)) {
            $demo    = session('demo_mode', []);
            $student = (object) [
                'name'    => $demo['name'] ?? '範例學員',
                'id'      => 'demo',
                'classID' => $demo['classID'] ?? null,
            ];
            $answersData = $demo['answers'] ?? [];
            $answers = collect(array_map(function ($qid, $ans) {
                return (object) ['questionID' => $qid, 'answer' => $ans];
            }, array_keys($answersData), array_values($answersData)));
            return view('student.StudentShow', [
                'student' => $student,
                'answers' => $answers,
                'isDemo'  => true,
            ]);
        }

        $student = student::find($Sid);
        $answers = answer::where('studentID', $Sid)->get();
        return view('student.StudentShow', [
            'student' => $student,
            'answers' => $answers,
            'isDemo'  => false,
        ]);
    }

    // ──────────────────────────────────────────────
    //  Other-assessment (他評) routes
    // ──────────────────────────────────────────────

    function OthersQuiz($Sid)
    {
        if ($this->isDemoSid($Sid)) {
            $demo    = session('demo_mode', []);
            $student = (object) [
                'name' => $demo['name'] ?? '範例學員',
                'id'   => 'demo',
            ];
            return view('student.OtherQuiz', ['student' => $student, 'isDemo' => true]);
        }

        $student = student::find($Sid);
        return view('student.OtherQuiz', ['student' => $student, 'isDemo' => false]);
    }

    function InputType($Sid)
    {
        if ($this->isDemoSid($Sid)) {
            $others = session('demo_mode.others', []);
            $idx    = count($others);
            $others[$idx] = ['type' => request('type'), 'done' => false, 'answers' => []];
            session(['demo_mode.others' => $others]);
            $Oid = 'demo_' . $idx;
            return redirect()->route('student.ResumeOtherQuiz', ['Sid' => 'demo', 'Oid' => $Oid]);
        }

        $other = other::create([
            'studentID' => $Sid,
            'type'      => request('type'),
        ]);
        return redirect()->route('student.ResumeOtherQuiz', ['Sid' => $Sid, 'Oid' => $other->id]);
    }

    function resumeOtherQuiz($Sid, $Oid)
    {
        if ($this->isDemoSid($Sid) || $this->isDemoOid($Oid)) {
            $idx     = $this->demoOidIndex($Oid);
            $answers = session('demo_mode.others.' . $idx . '.answers', []);
            $count   = count($answers);
            if ($count == 0) {
                return redirect()->route('student.OthersQuestion', ['Sid' => 'demo', 'Oid' => $Oid, 'Qid' => 13]);
            }
            if ($count >= 12) {
                return redirect()->route('student.OthersQuestion', ['Sid' => 'demo', 'Oid' => $Oid, 'Qid' => 24]);
            }
            $nextQid = max(array_keys($answers)) + 1;
            return redirect()->route('student.OthersQuestion', ['Sid' => 'demo', 'Oid' => $Oid, 'Qid' => $nextQid]);
        }

        $count = answer::where('otherID', $Oid)->count();
        if ($count == 0) {
            return redirect()->route('student.OthersQuestion', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => 13]);
        }
        if ($count >= 12) {
            return redirect()->route('student.OthersQuestion', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => 24]);
        }
        $nextQid = answer::where('otherID', $Oid)->max('questionID') + 1;
        return redirect()->route('student.OthersQuestion', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => $nextQid]);
    }

    function ShowOtherQuestion($Sid, $Oid, $Qid)
    {
        if ($Qid < 13 || $Qid > 24) abort(404);
        $question = question::findOrFail($Qid);

        if ($this->isDemoSid($Sid) || $this->isDemoOid($Oid)) {
            $idx           = $this->demoOidIndex($Oid);
            $currentAnswer = session('demo_mode.others.' . $idx . '.answers.' . $Qid);
            return view('student.OtherQuestion', [
                'question'      => $question,
                'Qid'           => $Qid,
                'Sid'           => 'demo',
                'Oid'           => $Oid,
                'currentAnswer' => $currentAnswer,
                'isDemo'        => true,
            ]);
        }

        $currentAnswer = answer::where('otherID', $Oid)
            ->where('questionID', $Qid)
            ->value('answer');
        return view('student.OtherQuestion', [
            'question'      => $question,
            'Qid'           => $Qid,
            'Sid'           => $Sid,
            'Oid'           => $Oid,
            'currentAnswer' => $currentAnswer,
            'isDemo'        => false,
        ]);
    }

    function StoreOtherAnswer($Sid, $Oid, $Qid)
    {
        if (request('answer') == null) {
            Alert::warning('未選擇答案');
            return back();
        }

        if ($this->isDemoSid($Sid) || $this->isDemoOid($Oid)) {
            $idx = $this->demoOidIndex($Oid);
            session(['demo_mode.others.' . $idx . '.answers.' . $Qid => request('answer')]);
            if ($Qid < 24) {
                return redirect()->route('student.ResumeOtherQuiz', ['Sid' => 'demo', 'Oid' => $Oid]);
            }
            session(['demo_mode.others.' . $idx . '.done' => true]);
            return view('student.OtherFinishQuiz', ['isDemo' => true]);
        }

        answer::updateOrCreate(
            ['otherID' => $Oid, 'questionID' => $Qid],
            ['answer' => request('answer')]
        );
        if ($Qid < 24) {
            return redirect()->route('student.ResumeOtherQuiz', ['Sid' => $Sid, 'Oid' => $Oid]);
        }
        $other = other::find($Oid);
        $other->update(['doneQuiz' => 1]);
        $student = student::find($Sid);
        $student->update(['OthersCount' => $student->OthersCount + 1]);
        return view('student.OtherFinishQuiz', ['isDemo' => false]);
    }

    function OtherIndex($Sid)
    {
        if ($this->isDemoSid($Sid)) {
            $demo    = session('demo_mode', []);
            $student = (object) [
                'name' => $demo['name'] ?? '範例學員',
                'id'   => 'demo',
            ];
            $othersData = $demo['others'] ?? [];
            $others = collect(array_map(function ($idx, $data) {
                return (object) [
                    'id'       => 'demo_' . $idx,
                    'type'     => $data['type'],
                    'doneQuiz' => $data['done'] ? 1 : 0,
                ];
            }, array_keys($othersData), array_values($othersData)));
            return view('student.OtherIndex', [
                'others'  => $others,
                'student' => $student,
                'isDemo'  => true,
            ]);
        }

        $student = student::find($Sid);
        $others  = other::where('studentID', $Sid)->get();
        $class   = $student ? course::find($student->classID) : null;
        return view('student.OtherIndex', [
            'others'  => $others,
            'student' => $student,
            'isDemo'  => $class && $class->ClassLink === 'demo',
        ]);
    }

    function OtherShow($Oid)
    {
        if ($this->isDemoOid($Oid)) {
            $idx         = $this->demoOidIndex($Oid);
            $answersData = session('demo_mode.others.' . $idx . '.answers', []);
            $answers = collect(array_map(function ($qid, $ans) {
                return (object) ['questionID' => $qid, 'answer' => $ans];
            }, array_keys($answersData), array_values($answersData)));
            return view('student.OtherShow', ['other' => null, 'answers' => $answers]);
        }

        $other   = student::find($Oid);
        $answers = answer::where('otherID', $Oid)->get();
        return view('student.OtherShow', ['other' => $other, 'answers' => $answers]);
    }

    // ──────────────────────────────────────────────
    //  Chart / PDF
    // ──────────────────────────────────────────────

    function Chart($Sid)
    {
        try {
        $img1 = $this->_buildChart1($Sid);
        $img2 = $this->_buildChart2($Sid);
        $img3 = $this->_buildChart3($Sid);
        $pdf  = PDF::loadView('student.output_pdf', [
            'Sid'    => $Sid,
            'chart1' => base64_encode((string) $img1->encode('jpg')),
            'chart2' => base64_encode((string) $img2->encode('jpg')),
            'chart3' => base64_encode((string) $img3->encode('jpg')),
        ]);
        $pdf->setPaper('A4');
        return $pdf->stream();
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ], 500);
        }
    }

    function MakeChart1($Sid)
    {
        return $this->_buildChart1($Sid)->response('jpg');
    }

    private function _buildChart1($Sid)
    {
        $student = student::find($Sid);
        $Sids    = answer::where('studentID', $Sid)->where('questionID', 12)->pluck('studentID');
        $S1 = 0; $S2 = 0; $S3 = 0; $S4 = 0;
        foreach ($Sids as $sid) {
            $answers = answer::where('studentID', $sid)->get();
            foreach ($answers as $answer) {
                $convert = question::find($answer->questionID);
                if ($answer->answer == $convert->convertS1) { $S1++; }
                if ($answer->answer == $convert->convertS2) { $S2++; }
                if ($answer->answer == $convert->convertS3) { $S3++; }
                if ($answer->answer == $convert->convertS4) { $S4++; }
            }
        }
        $img = Image::make(public_path('page1.jpg'));
        $img->text($student->name, 1340, 540, function ($font) {
            $font->file(public_path('font.ttf'));
            $font->size(72);
            $font->align('center');
            $font->valign('top');
        });
        $img->text($S1, 665, 1500, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S2, 665, 1390, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S3, 550, 1390, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S4, 550, 1500, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });

        $Oids = other::where('studentID', $Sid)->where('doneQuiz', 1)->pluck('id');
        $S1 = 0; $S2 = 0; $S3 = 0; $S4 = 0; $count = 0;
        foreach ($Oids as $Oid) {
            $answers = answer::where('otherID', $Oid)->get();
            foreach ($answers as $answer) {
                $count++;
                $convert = question::find($answer->questionID);
                if ($answer->answer == $convert->convertS1) { $S1++; }
                if ($answer->answer == $convert->convertS2) { $S2++; }
                if ($answer->answer == $convert->convertS3) { $S3++; }
                if ($answer->answer == $convert->convertS4) { $S4++; }
            }
        }
        $count = floor($count / 12);
        if ($count != 0) {
            $S1 = round($S1 / $count); $S2 = round($S2 / $count);
            $S3 = round($S3 / $count); $S4 = round($S4 / $count);
        }
        $img->text($S1, 1825, 1490, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S2, 1825, 1380, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S3, 1710, 1380, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S4, 1710, 1490, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        return $img;
    }

    function MakeChart2($Sid)
    {
        return $this->_buildChart2($Sid)->response('jpg');
    }

    private function _buildChart2($Sid)
    {
        $S1 = 0; $S2 = 0; $S3 = 0; $S4 = 0;
        $Sids = answer::where('studentID', $Sid)->where('questionID', 12)->pluck('studentID');
        foreach ($Sids as $sid) {
            $answers = answer::where('studentID', $sid)->get();
            foreach ($answers as $answer) {
                $weight = question::find($answer->questionID);
                if ($answer->answer == 'A') { $S1 += $weight->S1; }
                if ($answer->answer == 'B') { $S2 += $weight->S2; }
                if ($answer->answer == 'C') { $S3 += $weight->S3; }
                if ($answer->answer == 'D') { $S4 += $weight->S4; }
            }
        }
        $sum = $S1 + $S2 + $S3 + $S4;
        $img = Image::make(public_path('page2.jpg'));
        $img->text($S1,  645,  1815, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S2,  755,  1815, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S3,  865,  1815, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S4,  975,  1815, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($sum, 975,  1925, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(48); $font->align('center'); $font->valign('top'); });

        $Oids = other::where('studentID', $Sid)->where('doneQuiz', 1)->pluck('id');
        $S1 = 0; $S2 = 0; $S3 = 0; $S4 = 0; $count = 0;
        foreach ($Oids as $Oid) {
            $count++;
            $answers = answer::where('otherID', $Oid)->get();
            foreach ($answers as $answer) {
                $weight = question::find($answer->questionID);
                if ($answer->answer == 'A') { $S1 += $weight->S1; }
                if ($answer->answer == 'B') { $S2 += $weight->S2; }
                if ($answer->answer == 'C') { $S3 += $weight->S3; }
                if ($answer->answer == 'D') { $S4 += $weight->S4; }
            }
        }
        if ($count != 0) {
            $S1 = round($S1 / $count); $S2 = round($S2 / $count);
            $S3 = round($S3 / $count); $S4 = round($S4 / $count);
        }
        $sum = round($S1 + $S2 + $S3 + $S4);
        $img->text($S1,  1375, 1790, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S2,  1485, 1790, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S3,  1595, 1790, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S4,  1705, 1790, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($sum, 1705, 1900, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(48); $font->align('center'); $font->valign('top'); });
        return $img;
    }

    function MakeChart3($Sid)
    {
        return $this->_buildChart3($Sid)->response('jpg');
    }

    private function _buildChart3($Sid)
    {
        $img = Image::make(public_path('page3.jpg'));
        $Oids = other::where('studentID', $Sid)->where('doneQuiz', 1)->pluck('id');
        $S1 = 0; $S2 = 0; $S3 = 0; $S4 = 0;
        $R1S1 = 0; $R1S2 = 0; $R1S3 = 0; $R1S4 = 0;
        $R2S1 = 0; $R2S2 = 0; $R2S3 = 0; $R2S4 = 0;
        $R3S1 = 0; $R3S2 = 0; $R3S3 = 0; $R3S4 = 0;
        $R4S1 = 0; $R4S2 = 0; $R4S3 = 0; $R4S4 = 0;
        $result = 0;
        foreach ($Oids as $Oid) {
            $answers = answer::where('otherID', $Oid)->get();
            foreach ($answers as $answer) {
                $convert = question::find($answer->questionID);
                if ($answer->answer == $convert->convertS1) {
                    $S1++;
                    if (in_array($answer->questionID, [13, 17, 21])) { $R1S1++; }
                    if (in_array($answer->questionID, [14, 18, 22])) { $R2S1++; }
                    if (in_array($answer->questionID, [15, 19, 23])) { $R3S1++; }
                    if (in_array($answer->questionID, [16, 20, 24])) { $R4S1++; }
                }
                if ($answer->answer == $convert->convertS2) {
                    $S2++;
                    if (in_array($answer->questionID, [13, 17, 21])) { $R1S2++; }
                    if (in_array($answer->questionID, [14, 18, 22])) { $R2S2++; }
                    if (in_array($answer->questionID, [15, 19, 23])) { $R3S2++; }
                    if (in_array($answer->questionID, [16, 20, 24])) { $R4S2++; }
                }
                if ($answer->answer == $convert->convertS3) {
                    $S3++;
                    if (in_array($answer->questionID, [13, 17, 21])) { $R1S3++; }
                    if (in_array($answer->questionID, [14, 18, 22])) { $R2S3++; }
                    if (in_array($answer->questionID, [15, 19, 23])) { $R3S3++; }
                    if (in_array($answer->questionID, [16, 20, 24])) { $R4S3++; }
                }
                if ($answer->answer == $convert->convertS4) {
                    $S4++;
                    if (in_array($answer->questionID, [13, 17, 21])) { $R1S4++; }
                    if (in_array($answer->questionID, [14, 18, 22])) { $R2S4++; }
                    if (in_array($answer->questionID, [15, 19, 23])) { $R3S4++; }
                    if (in_array($answer->questionID, [16, 20, 24])) { $R4S4++; }
                }
            }
        }
        $OverLead = $R4S1 + $R3S1 + $R2S1 + $R4S2 + $R3S2 + $R4S3;
        $LessLead = $R3S4 + $R2S4 + $R1S4 + $R2S3 + $R1S3 + $R1S2;
        $sum  = $S1 + $S2 + $S3 + $S4;
        $sum2 = $R4S4 + $R3S3 + $R2S2 + $R1S1;
        if ($sum != 0) {
            $result = round($sum2 / $sum, 2) * 100;
        }
        $result = ((string) $result) . '%';

        $img->text($S1,      630,  1725, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S2,      630,  1510, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S3,      630,  1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($S4,      630,  1080, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R1S1,    1610, 1725, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R1S2,    1610, 1510, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R1S3,    1610, 1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R1S4,    1610, 1080, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R2S1,    1365, 1725, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R2S2,    1365, 1510, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R2S3,    1365, 1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R2S4,    1365, 1080, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R3S1,    1120, 1725, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R3S2,    1120, 1510, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R3S3,    1120, 1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R3S4,    1120, 1080, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R4S1,    875,  1725, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R4S2,    875,  1510, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R4S3,    875,  1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($R4S4,    875,  1080, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); });
        $img->text($OverLead, 415, 1295, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); $font->angle(90); });
        $img->text($LessLead, 1790, 1075, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(36); $font->align('center'); $font->valign('top'); $font->angle(90); });
        $img->text($sum,     355,  2175, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(48); $font->align('center'); $font->valign('top'); });
        $img->text($sum2,    885,  2175, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(48); $font->align('center'); $font->valign('top'); });
        $img->text($result,  885,  2290, function ($font) { $font->file(public_path('OpenSans-SemiboldItalic.ttf')); $font->size(48); $font->align('center'); $font->valign('top'); });
        return $img;
    }

    // ──────────────────────────────────────────────
    //  Admin-side destroy actions
    // ──────────────────────────────────────────────

    function destroyStudent($Sid)
    {
        $student = student::findOrFail($Sid);
        $classId = $student->classID;
        $class   = course::find($classId);
        if ($class && $class->ClassLink === 'demo') {
            return back()->with('error', '範例課程的學員資料無法刪除');
        }
        $name     = $student->name;
        $otherIds = other::where('studentID', $Sid)->pluck('id');
        answer::whereIn('otherID', $otherIds)->delete();
        other::where('studentID', $Sid)->delete();
        answer::where('studentID', $Sid)->delete();
        $student->delete();
        return redirect()->route('backend.ClassShow', ['id' => $classId])
            ->with('success', '學員「' . $name . '」已成功刪除');
    }

    function destroyOther($Oid)
    {
        $other = other::findOrFail($Oid);
        $sid   = $other->studentID;
        $stu   = student::find($sid);
        $class = $stu ? course::find($stu->classID) : null;
        if ($class && $class->ClassLink === 'demo') {
            return back()->with('error', '範例課程的評量記錄無法刪除');
        }
        answer::where('otherID', $Oid)->delete();
        $other->delete();
        $student = student::find($sid);
        if ($student && $student->OthersCount > 0) {
            $student->decrement('OthersCount');
        }
        return redirect()->route('student.OtherIndex', ['Sid' => $sid])
            ->with('success', '評量記錄已成功刪除');
    }

    public function logo()
    {
        $img = Image::make(public_path('logo.png'));
        return $img->response('png');
    }
}
