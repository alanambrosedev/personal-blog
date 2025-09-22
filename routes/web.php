<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureUserHasRole;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::with('category', 'tags')
        ->latest()
        ->take(5)
        ->get();

    return view('pages.home', ['posts' => $posts]);
    // Middleware can take extra arguments.The colon is used to pass arguments to the middleware.
})->name('home')->middleware(EnsureUserHasRole::class.':editor,publisher');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::view('about', 'pages.about')->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Skip middleware for specific routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->withoutMiddleware(EnsureTokenValid::class);

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('tags', Admin\TagController::class);
    Route::resource('posts', Admin\PostController::class);
});
if (app()->environment('local')) {
    // Middleware Groups Routes
    Route::group(['middleware' => ['auth-lookup'], 'prefix' => '{locale}/admin', 'as' => 'admin.'], function () {
        Route::resource('categories', Admin\CategoryController::class); // fi/admin/categories
    });
}


require __DIR__.'/auth.php';
