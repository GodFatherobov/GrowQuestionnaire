<?php

use App\Models\answer;
use App\Models\course;
use App\Models\other;
use App\Models\question;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/students',function (){
    return student::all();
});
Route::get('/classes',function (){
    return course::all();
});
Route::get('/users',function (){
    return User::all();
});
Route::get('/answers',function (){
    return answer::all();
});
Route::get('/questions',function (){
    return question::all();
});
Route::get('/others',function (){
    return other::all();
});
