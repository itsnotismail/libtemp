<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\LateReturnController;
use App\Http\Controllers\UserController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books');
    Route::post('/create', [BookController::class, 'create']);
    Route::post('/update', [BookController::class, 'update']);
    Route::post('/delete', [BookController::class, 'delete']);
});

Route::prefix('/borrowers')->group(function () {
    Route::get('/', [BorrowerController::class, 'index'])->name('borrowers');
    Route::post('/create', [BorrowerController::class, 'create']);
    Route::post('/update', [BorrowerController::class, 'update']);
    Route::post('/delete', [BorrowerController::class, 'delete']);
});

Route::prefix('/borrows')->group(function () {
    Route::get('/', [BorrowController::class, 'index'])->name('borrows');
    Route::post('/create', [BorrowController::class, 'create']);
    Route::post('/update', [BorrowController::class, 'update']);
    Route::post('/delete', [BorrowController::class, 'delete']);
});

Route::prefix('/bookReturns')->group(function () {
    Route::get('/', [BookReturnController::class, 'index'])->name('bookReturns');
    // Route::post('/create', [BookReturnController::class, 'create']);
    Route::post('/update', [BookReturnController::class, 'update']);
    // Route::post('/delete', [BookReturnController::class, 'delete']);
});

Route::prefix('lateReturns')->group(function () {
    Route::get('/', [LateReturnController::class, 'index'])->name('lateReturns');
    // Route::post('/create', [LateReturnController::class, 'create']);
    Route::post('/update', [LateReturnController::class, 'update']);
    // Route::post('/delete', [LateReturnController::class, 'delete']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::post('/update', [UserController::class, 'update']);
    Route::post('/delete', [UserController::class, 'delete']);
});