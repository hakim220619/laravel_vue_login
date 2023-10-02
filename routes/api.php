<?php

use App\Http\Controllers\Api\AplikasiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BilPaymentController;
use App\Http\Controllers\Api\SettingController;
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
    //aplikasi
    Route::get('/getAplikasi', [AplikasiController::class, 'index'])->name('getAplikasi');
    //Users
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/getProvince', [UsersController::class, 'getProvince'])->name('getProvince');
    Route::get('/getRegency/{id}', [UsersController::class, 'getRegency'])->name('getRegency');
    Route::post('/addUsers', [UsersController::class, 'store'])->name('users.addUsers');
    Route::get('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
    Route::get('/users/showUsers/{id}', [UsersController::class, 'edit'])->name('users.showUsers');
    Route::get('/getClass', [UsersController::class, 'getClass'])->name('users.getClass');
    Route::get('/getMajor', [UsersController::class, 'getMajor'])->name('users.getMajor');
    Route::post('/updateUsers', [UsersController::class, 'update'])->name('users.updateUsers');

    //students
    Route::get('/students', [StudentsController::class, 'index'])->name('students');
    Route::post('/addStudents', [StudentsController::class, 'store'])->name('students.addStudents');
    Route::get('/students/delete/{id}', [StudentsController::class, 'destroy'])->name('students.delete');
    Route::get('/showStudents/{id}', [StudentsController::class, 'edit'])->name('students.showStudents');
    Route::post('/UpdateStudents', [StudentsController::class, 'update'])->name('students.UpdateStudents');


    //settingPayment
    // Route::get('/settingPayment', [SettingController::class, 'index'])->name('settingPayment');
    // Route::get('/getYears', [SettingController::class, 'getYears'])->name('settingPayment.getYears');
    // Route::post('/addBillPayment', [SettingController::class, 'store'])->name('settingPayment.addBillPayment');
    // Route::get('/settingPayment/delete/{id}', [SettingController::class, 'destroy'])->name('settingPayment.delete');
    // Route::get('/showBillPayment/{id}', [SettingController::class, 'edit'])->name('settingPayment.showBillPayment');
    // Route::post('/UpdateBillPayment', [SettingController::class, 'update'])->name('students.UpdateBillPayment');
    //Bill Payment
    Route::get('/billPayment', [BilPaymentController::class, 'index'])->name('billPayment');
    Route::get('/getYears', [BilPaymentController::class, 'getYears'])->name('billPayment.getYears');
    Route::post('/addBillPayment', [BilPaymentController::class, 'store'])->name('billPayment.addBillPayment');
    Route::get('/billPayment/delete/{id}', [BilPaymentController::class, 'destroy'])->name('billPayment.delete');
    Route::get('/showBillPayment/{id}', [BilPaymentController::class, 'edit'])->name('billPayment.showBillPayment');
    Route::post('/UpdateBillPayment', [BilPaymentController::class, 'update'])->name('students.UpdateBillPayment');
    Route::get('/getMonths', [BilPaymentController::class, 'getMonths'])->name('students.getMonths');
    //Auth
    Route::post('/getUsers', [AuthController::class, 'getUsers'])->name('getUsers');
    Route::get('/logout', [AuthController::class, 'logout']);
});
