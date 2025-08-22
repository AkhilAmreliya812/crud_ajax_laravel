<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', [StudentController::class, 'home'])->name('/');
Route::post('getStates', [StudentController::class, 'getStates'])->name('getStates');
Route::post('getCities', [StudentController::class, 'getCities'])->name('getCities');
Route::post('addStudent', [StudentController::class, 'addStudent'])->name('addStudent');
Route::post('deleteStudent', [StudentController::class, 'deleteStudent'])->name('deleteStudent');
Route::post('viewStudent', [StudentController::class, 'findStudent'])->name('viewStudent');
Route::post('editStudent',[StudentController::class,'findStudent'])->name('editStudent');
Route::post('updateStudent',[StudentController::class,'updateStudent'])->name('updateStudent');
Route::get('getStudents', [StudentController::class, 'getStudents'])->name('getStudents');