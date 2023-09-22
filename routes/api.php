<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    //Users
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/getProvince', [UsersController::class, 'getProvince'])->name('getProvince');
    Route::get('/getRegency/{id}', [UsersController::class, 'getRegency'])->name('getRegency');
    Route::post('/addUsers', [UsersController::class, 'store'])->name('users.addUsers');
    Route::get('/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
    Route::get('/showUsers/{id}', [UsersController::class, 'show'])->name('users.showUsers');
    Route::get('/getClass', [UsersController::class, 'getClass'])->name('users.getClass');
    Route::get('/getMajor', [UsersController::class, 'getMajor'])->name('users.getMajor');
    Route::post('/updateUsers', [UsersController::class, 'update'])->name('users.updateUsers');

    //students
    Route::get('/students', [StudentsController::class, 'index'])->name('students');
    Route::post('/addStudents', [StudentsController::class, 'store'])->name('students.addStudents');
    Route::get('/students/delete/{id}', [StudentsController::class, 'destroy'])->name('students.delete');
    Route::get('/showStudents/{id}', [StudentsController::class, 'edit'])->name('students.showStudents');
    Route::post('/UpdateStudents', [StudentsController::class, 'update'])->name('students.UpdateStudents');
    //Auth
    Route::post('/getUsers', [AuthController::class, 'getUsers'])->name('getUsers');
    Route::get('/logout', [AuthController::class, 'logout']);
});
