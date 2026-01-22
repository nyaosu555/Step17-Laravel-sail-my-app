<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::resource('post', PostController::class);

Route::get('/', function() {
    return view('welcome');
});

Route::get('dashboard', function() {
    return view('dashboard');
}) -> name('dashboard');

Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit']) -> name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy']) -> name('profile.destroy');
});

require __DIR__.'/auth.php';

// ---通常の書き方にしたい場合は以下のコメントアウトを無しにする---
// Route::get('/', function () {
//     return view('welcome');
// }) -> middleware('auth');
// // }) -> middleware('can:test');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/test', [TestController::class, 'test'])->name('test');

// require __DIR__.'/auth.php';

// Route::get('posts', [PostController::class, 'index'])->name('post.index');

// // Route::get('post/create', [PostController::class, 'create'])
// // ->middleware('auth', 'role');

// Route::get('post/create', [PostController::class, 'create']);

// // Route::middleware(['auth', 'role'])->group(function() {
// //     Route::post('post', [PostController::class, 'store'])->name('post.store');
// //     Route::get('post/create', [PostController::class, 'create']);
// // });

// Route::post('post', [PostController::class, 'store'])->name('post.store');

// // 個別表示
// Route::get('post/show/{post}', [PostController::class, 'show'])->name('post.show');

// // 編集機能
// Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
// Route::patch('post/{post}', [PostController::class, 'update'])->name('post.update');

// // 削除機能
// Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
// ---通常の書き方ここまで---
