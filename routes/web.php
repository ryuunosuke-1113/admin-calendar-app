<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 管理画面トップ
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/calendar', [EventController::class, 'calendar'])->name('admin.calendar');
     Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
      Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
      Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])
    ->name('admin.events.destroy');
    Route::patch('/admin/events/{event}', [EventController::class, 'update'])
    ->name('admin.events.update');



    // お知らせCRUD（管理画面）
    Route::resource('/admin/news', NewsController::class)->names('admin.news');

    // コメント投稿（ログインユーザーならOK）
    Route::post('/admin/news/{news}/comments', [CommentController::class, 'store'])
        ->name('admin.news.comments.store');

    // 返信投稿（お知らせ作成者だけ、などの制御はController側で）
    Route::post('/admin/news/{news}/comments/{comment}/reply', [CommentController::class, 'reply'])
        ->name('admin.news.comments.reply')
        ->scopeBindings();

    // プロフィール（Breeze標準）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
