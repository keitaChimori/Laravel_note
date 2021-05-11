<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::group(['middlewere' => 'Auth'], function(){
    // ホーム画面表示
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // メモ新規投稿画面表示
    Route::get('/create', [HomeController::class, 'create'])->name('create');
    // メモ新規投稿実行
    Route::post('/store', [HomeController::class, 'store'])->name('store');
    // メモ編集表示
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
    // メモ編集実行
    Route::post('/update/{id}', [HomeController::class, 'update'])->name('update');
    // メモ削除
    Route::get('/delete/{id}', [HomeController::class, 'delete'])->name('delete');
});