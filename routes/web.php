<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});

//Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logo', [App\Http\Controllers\StudentController::class, 'logo'])->name('logo');

Route::get('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'Quiz'])->name('student.StudentQuiz');
Route::post('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'InputName'])->name('student.StudentQuiz');
Route::get('/Quiz/{Sid}/{Qid}', [App\Http\Controllers\StudentController::class, 'ShowQuestion'])->name('student.Question');
Route::post('/StoreAnswer/{Sid}/{Qid}', [App\Http\Controllers\StudentController::class, 'StoreAnswer'])->name('student.StoreAnswer');
Route::get('/Student/{Sid}', [App\Http\Controllers\StudentController::class, 'StudentShow'])->name('student.StudentShow');
Route::get('/Student/{Sid}/MakeChart1', [App\Http\Controllers\StudentController::class, 'MakeChart1'])->name('student.MakeChart1');
Route::get('/Student/{Sid}/MakeChart2', [App\Http\Controllers\StudentController::class, 'MakeChart2'])->name('student.MakeChart2');
Route::get('/Student/{Sid}/MakeChart3', [App\Http\Controllers\StudentController::class, 'MakeChart3'])->name('student.MakeChart3');
Route::get('/Student/{Sid}/chart', [App\Http\Controllers\StudentController::class, 'Chart'])->name('student.page2_pdf');




Route::get('/{Sid}/others', [App\Http\Controllers\StudentController::class, 'OthersQuiz'])->name('student.OthersQuiz');
Route::post('/{Sid}/others', [App\Http\Controllers\StudentController::class, 'InputType'])->name('student.OthersQuiz');
Route::get('/{Sid}/others/{Oid}/{Qid}', [App\Http\Controllers\StudentController::class, 'ShowOtherQuestion'])->name('student.OthersQuestion');
Route::post('/{Sid}/others/{Oid}/{Qid}', [App\Http\Controllers\StudentController::class, 'StoreOtherAnswer'])->name('student.StoreOtherAnswer');
Route::get('/{Sid}/OtherIndex', [App\Http\Controllers\StudentController::class, 'OtherIndex'])->name('student.OtherIndex');
Route::get('/OtherShow/{Oid}', [App\Http\Controllers\StudentController::class, 'OtherShow'])->name('student.OtherShow');

Route::get('/AdminLogin', [App\Http\Controllers\AdminController::class, 'LoginPage'])->name('backend.AdminLogin');
Route::post('/AdminLogin', [App\Http\Controllers\AdminController::class, 'login'])->name('backend.AdminLogin');
Route::get('/ClassIndex', [App\Http\Controllers\AdminController::class, 'ClassIndex'])->name('backend.ClassIndex');
Route::post('/ClassCreate', [App\Http\Controllers\AdminController::class, 'ClassCreate'])->name('backend.ClassCreate');
Route::get('/Class/{id}', [App\Http\Controllers\AdminController::class, 'ClassShow'])->name('backend.ClassShow');



Route::get('/test', [App\Http\Controllers\AdminController::class, 'test'])->name('test');
