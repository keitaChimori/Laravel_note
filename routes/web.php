<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ホーム画面表示
Route::get('/home', [HomeController::class, 'index'])->name('home');
// メモ新規投稿画面表示
Route::get('/create', [HomeController::class, 'create'])->name('create');
// メモ新規投稿実行
Route::post('/store', [HomeController::class, 'store'])->name('store');
// メモ編集表示
Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
// メモ編集実行
Route::post('/update/{id}', [HomeController::class, 'update'])->name('update');