<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RetweetController;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('tweets', TweetController::class);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'show'])->name('mypage.show');
    Route::put('/mypage', [MypageController::class, 'update'])->name('mypage.update');
    Route::get('/tweets/create', [TweetController::class, 'create'])->name('tweets.create');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::get('/tweets/{id}', [TweetController::class, 'show'])->name('tweets.show');
    Route::get('tweets/{id}/edit', [TweetController::class, 'edit'])->name('tweets.edit');
    Route::put('tweets/{id}', [TweetController::class, 'update'])->name('tweets.update');
    Route::delete('tweets/{id}', [TweetController::class, 'destroy'])->name('tweets.destroy');

    // いいねの追加/削除
    Route::post('/tweets/{tweet}/like', [LikeController::class, 'store'])->name('likes.store');

    // コメント追加
    Route::post('/tweets/{tweet}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // リツイート
    Route::post('/tweets/{tweet}/retweets', [RetweetController::class, 'store'])->name('retweets.create');
});

Route::get('/phpinfo', function () {
    phpinfo();
});
