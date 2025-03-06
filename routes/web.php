<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/schools/jumlahsiswa', [SchoolController::class, 'getStudentCount']);
Route::apiResource('schools', SchoolController::class);
Route::apiResource('students', StudentController::class);
Route::get('/students/{id}/school', [StudentController::class, 'getSchool']);
