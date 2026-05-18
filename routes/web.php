<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ExampController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function (){
    Route::get('/', function () {
    return redirect()->route('students.index');
});

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

Route::get('/examps', [ExampController::class, 'index'])->name('examps.index');
Route::post('/examps', [ExampController::class, 'store'])->name('examps.store');
Route::delete('/examps/{examp}', [ExampController::class, 'destroy'])->name('examps.destroy');


Route::get('/scanner/{room_id}', [AttendanceController::class, 'index'])->name('scanner'); 
Route::get('/check-rfid/{uid}/{room_id}', [AttendanceController::class, 'checkRfid']);
Route::post('/attendance/store', [AttendanceController::class, 'store']);
Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
 
Route::resource('students', StudentController::class);

Route::get('/placements', [PlacementController::class, 'index'])->name('placements.index');
Route::post('/placements', [PlacementController::class, 'store'])->name('placements.store');
Route::delete('/placements/{placement}', [PlacementController::class, 'destroy'])->name('placements.destroy');


Route::get('/monitor/{room_id}', [MonitorController::class, 'index'])->name('monitor.index');
Route::get('/monitor/data/{room_id}', [MonitorController::class, 'getData']);


});
