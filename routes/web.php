<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::with('category', 'tags')
        ->latest()
        ->take(5)
        ->get();

    return view('pages.home', ['posts' => $posts]);
})->name('home');

Route::get('posts', [PostController::class, 'index'])->name('posts.index'); // posts
Route::get('posts/{post:title}', [PostController::class, 'show'])->withTrashed()->name('posts.show'); // posts/{title} since using route model binding use here withTrashed()
Route::view('about', 'pages.about')->name('about')->missing(function () {
    return view('posts.index');
}); // posts/about and if missing redirect to index page

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::resource('categories', Admin\CategoryController::class); // admin/categories
    Route::resource('tags', Admin\TagController::class); // admin/tags
    Route::resource('posts', Admin\PostController::class); // admin/posts
});
if (app()->environment('local')) {
    Route::group(['middleware' => ['auth', 'setLocale'], 'prefix' => '{locale}/admin', 'as' => 'admin.'], function () {
        Route::resource('categories', Admin\CategoryController::class); // fi/admin/categories
    });
}

require __DIR__.'/auth.php';
