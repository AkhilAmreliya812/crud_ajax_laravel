<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('home');
});


Route::get('students', [StudentController::class, 'getStudents'])->name('getStudents');
Route::post('addStudent', [StudentController::class, 'addStudent'])->name('addStudent');
Route::post('deleteStudent', [StudentController::class, 'deleteStudent'])->name('deleteStudent');
Route::post('viewStudent', [StudentController::class, 'findStudent'])->name('viewStudent');
Route::post('editStudent',[StudentController::class,'findStudent'])->name('editStudent');
Route::post('updateStudent',[StudentController::class,'updateStudent'])->name('updateStudent');
