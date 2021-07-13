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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'Quiz'])->name('student.StudentQuiz');
Route::post('/{ClassLink}/Quiz', [App\Http\Controllers\StudentController::class, 'InputName'])->name('student.StudentQuiz');
Route::get('/AdminLogin', [App\Http\Controllers\AdminController::class, 'LoginPage'])->name('backend.AdminLogin');
Route::post('/AdminLogin', [App\Http\Controllers\AdminController::class, 'login'])->name('backend.AdminLogin');
Route::get('/ClassIndex', [App\Http\Controllers\AdminController::class, 'ClassIndex'])->name('backend.ClassIndex');
Route::post('/ClassCreate', [App\Http\Controllers\AdminController::class, 'ClassCreate'])->name('backend.ClassCreate');
Route::get('/Class/{id}', [App\Http\Controllers\AdminController::class, 'ClassShow'])->name('backend.ClassShow');
Route::get('/StudentIndex', [App\Http\Controllers\StudentController::class, 'StudentIndex'])->name('Student.StudentIndex');
