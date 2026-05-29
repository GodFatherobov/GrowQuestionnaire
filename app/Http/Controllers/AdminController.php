<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\course;
use App\Models\other;
use App\Models\student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    function login()
    {
        $credentials = [
            'email'    => request('account'),
            'password' => request('password'),
        ];

        if (Auth::attempt($credentials, true)) {
            request()->session()->regenerate();
            return Redirect::to('/ClassIndex');
        }

        return back()->withErrors(['account' => '帳號或密碼錯誤，請重新輸入']);
    }

    function LoginPage()
    {
        if (Auth::check()) {
            return redirect()->route('backend.ClassIndex');
        }
        return view('backend.AdminLogin');
    }

    function DemoShow()
    {
        $class    = course::where('ClassLink', 'demo')->firstOrFail();
        $students = student::where('classID', $class->id)->get();

        $completed  = $students->filter(function ($s) {
            return answer::where('studentID', $s->id)->whereNull('otherID')->count() == 12;
        })->count();

        $inProgress = $students->filter(function ($s) {
            $count = answer::where('studentID', $s->id)->whereNull('otherID')->count();
            return $count > 0 && $count < 12;
        })->count();

        $notStarted = $students->filter(function ($s) {
            return answer::where('studentID', $s->id)->whereNull('otherID')->count() == 0;
        })->count();

        return view('backend.ClassShow', [
            'id'         => $class->id,
            'class'      => $class,
            'students'   => $students,
            'completed'  => $completed,
            'inProgress' => $inProgress,
            'notStarted' => $notStarted,
        ]);
    }

    function ClassIndex()
    {
        $classes = course::where(function ($q) {
            $q->where('user_id', Auth::id())->orWhereNull('user_id');
        })->get();
        return view('backend.ClassIndex', [
            'classes' => $classes,
        ]);
    }

    function ClassCreate()
    {
        $ClassLink = Str::random(10);
        if (is_numeric(request('people')) == false) {
            Alert::warning('人數必須輸入數字');
            return back();
        }
        course::create([
            'ClassName' => request('ClassName'),
            'ClassLink' => $ClassLink,
            'People'    => request('people'),
            'user_id'   => Auth::id(),
        ]);
        return Redirect::to('/ClassIndex');
    }

    function ClassUpdate($id)
    {
        $class = course::where('id', $id)
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })->firstOrFail();

        if ($class->ClassLink === 'demo') {
            return back()->with('error', '範例課程的人數無法修改');
        }

        $people = request('People');
        if (!is_numeric($people) || (int) $people < 1) {
            return back()->with('error', '人數必須為正整數');
        }

        $class->update(['People' => (int) $people]);
        return back()->with('success', '課程人數已更新為 ' . (int) $people . ' 人');
    }

    function destroy($id)
    {
        $class = course::where('id', $id)
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })->firstOrFail();
        if ($class->ClassLink === 'demo') {
            return back()->with('error', '範例課程無法刪除');
        }
        $students = student::where('classID', $id)->get();
        foreach ($students as $s) {
            $otherIds = other::where('studentID', $s->id)->pluck('id');
            answer::whereIn('otherID', $otherIds)->delete();
            other::where('studentID', $s->id)->delete();
            answer::where('studentID', $s->id)->delete();
        }
        student::where('classID', $id)->delete();
        $name = $class->ClassName;
        $class->delete();
        return redirect()->route('backend.ClassIndex')
            ->with('success', '課程「' . $name . '」已成功刪除');
    }

    function ClassShow($id)
    {
        $class = course::where('id', $id)
            ->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            })->firstOrFail();
        $students = student::where('classID', '=', $id)->get();

        $completed  = $students->filter(function ($s) {
            return answer::where('studentID', $s->id)->whereNull('otherID')->count() == 12;
        })->count();

        $inProgress = $students->filter(function ($s) {
            $count = answer::where('studentID', $s->id)->whereNull('otherID')->count();
            return $count > 0 && $count < 12;
        })->count();

        $notStarted = $students->filter(function ($s) {
            return answer::where('studentID', $s->id)->whereNull('otherID')->count() == 0;
        })->count();

        return view('backend.ClassShow', [
            'id'          => $id,
            'class'       => $class,
            'students'    => $students,
            'completed'   => $completed,
            'inProgress'  => $inProgress,
            'notStarted'  => $notStarted,
        ]);
    }
}
