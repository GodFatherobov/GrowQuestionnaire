<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    function login()
    {
        $account = request('account');
        $password = request('password');
        $passwords = User::where('name', '=', $account)->pluck('password');
        $userId= User::where('name', '=', $account)->pluck('id');
        if ($passwords->isEmpty()) {
            dd('wrong password or account');
        } else {
            if ($password == $passwords[0]) {
                Auth::loginUsingId($userId[0], true);
                return Redirect::to('/ClassIndex');
                //return view('backend.ClassIndex');
            } else {
                dd('wrong password or account');
            }
        }
    }

    function LoginPage(){
        User::create([
            'name'=>'lanschen',
            'password'=>'coffeec2'
        ]);
        return view('backend.AdminLogin');
    }
    function ClassIndex(){
        if (Auth::check()){
            $classes=course::all();
            return view('backend.ClassIndex',[
                'classes'=> $classes,
            ]);
        }
        else{
            return ('you not login ya');
        }
    }
    function ClassCreate(){
        course::create([
            'ClassName'=>request('ClassName')
        ]);
        return Redirect::to('/ClassIndex');
    }
    function ClassShow($id){
        $class=course::Find($id);
        $students=student::where('classID', '=', $id)->get();
        return view('backend.ClassShow',[
            'id'=> $id,
            'class'=>$class,
            'students'=>$students,
        ]);
    }
}
