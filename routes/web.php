<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\TweetController;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/mypage', [MypageController::class, 'show'])->name('mypage.show');
Route::put('/mypage', [MyPageController::class, 'update'])->name('mypage.update');

Route::get('/tweets/create', [TweetController::class, 'create'])->name('tweets.create');
Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

Route::get('/phpinfo', function () {
    phpinfo();
});

