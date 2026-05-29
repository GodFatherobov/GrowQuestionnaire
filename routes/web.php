<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () { return view('welcome'); })->name('home');

// Admin login – named 'login' so the auth middleware knows where to redirect
Route::get('/login', [App\Http\Controllers\AdminController::class, 'LoginPage'])->name('login');
Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('backend.AdminLogin');

// Laravel UI: register, logout, password reset (login is handled by the custom route above)
Auth::routes(['login' => false]);

// Public demo route
Route::get('/demo', [App\Http\Controllers\AdminController::class, 'DemoShow'])->name('demo.show');

// Public student-facing routes
Route::get('/logo', [App\Http\Controllers\StudentController::class, 'logo'])->name('logo');

Route::get('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'Quiz'])->name('student.StudentQuiz');
Route::post('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'InputName']);
Route::get('/Quiz/{Sid}', [App\Http\Controllers\StudentController::class, 'resumeQuiz'])->name('student.ResumeQuiz');
Route::get('/Quiz/{Sid}/{Qid}', [App\Http\Controllers\StudentController::class, 'ShowQuestion'])->name('student.Question');
Route::post('/StoreAnswer/{Sid}/{Qid}', [App\Http\Controllers\StudentController::class, 'StoreAnswer'])->name('student.StoreAnswer');
Route::get('/Student/{Sid}', [App\Http\Controllers\StudentController::class, 'StudentShow'])->name('student.StudentShow');
Route::get('/Student/{Sid}/MakeChart1', [App\Http\Controllers\StudentController::class, 'MakeChart1'])->name('student.MakeChart1');
Route::get('/Student/{Sid}/MakeChart2', [App\Http\Controllers\StudentController::class, 'MakeChart2'])->name('student.MakeChart2');
Route::get('/Student/{Sid}/MakeChart3', [App\Http\Controllers\StudentController::class, 'MakeChart3'])->name('student.MakeChart3');
Route::get('/Student/{Sid}/chart', [App\Http\Controllers\StudentController::class, 'Chart'])->name('student.page2_pdf');

Route::get('/{Sid}/others', [App\Http\Controllers\StudentController::class, 'OthersQuiz'])->name('student.OthersQuiz');
Route::post('/{Sid}/others', [App\Http\Controllers\StudentController::class, 'InputType']);
Route::get('/{Sid}/others/{Oid}', [App\Http\Controllers\StudentController::class, 'resumeOtherQuiz'])->name('student.ResumeOtherQuiz');
Route::get('/{Sid}/others/{Oid}/{Qid}', [App\Http\Controllers\StudentController::class, 'ShowOtherQuestion'])->name('student.OthersQuestion');
Route::post('/{Sid}/others/{Oid}/{Qid}', [App\Http\Controllers\StudentController::class, 'StoreOtherAnswer'])->name('student.StoreOtherAnswer');
Route::get('/{Sid}/OtherIndex', [App\Http\Controllers\StudentController::class, 'OtherIndex'])->name('student.OtherIndex');
Route::get('/OtherShow/{Oid}', [App\Http\Controllers\StudentController::class, 'OtherShow'])->name('student.OtherShow');

// Protected admin routes – all require authentication
Route::middleware('auth')->group(function () {
    Route::get('/ClassIndex', [App\Http\Controllers\AdminController::class, 'ClassIndex'])->name('backend.ClassIndex');
    Route::post('/ClassCreate', [App\Http\Controllers\AdminController::class, 'ClassCreate'])->name('backend.ClassCreate');
    Route::get('/Class/{id}', [App\Http\Controllers\AdminController::class, 'ClassShow'])->name('backend.ClassShow');
    Route::patch('/Class/{id}', [App\Http\Controllers\AdminController::class, 'ClassUpdate'])->name('backend.ClassUpdate');
    Route::delete('/Class/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('backend.ClassDestroy');
    Route::delete('/Student/{Sid}', [App\Http\Controllers\StudentController::class, 'destroyStudent'])->name('student.destroyStudent');
    Route::delete('/Other/{Oid}', [App\Http\Controllers\StudentController::class, 'destroyOther'])->name('student.destroyOther');
});
