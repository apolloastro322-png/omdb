<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use App\Http\Controllers\PanelControl\FavoriteController;
use App\Http\Controllers\PanelControl\MovieController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);

    return redirect()->back();
})->name('lang.switch');

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');

Route::get('/movies', [MovieController::class, 'index'])->name('movies');
Route::get('/movies/{imdbID}', [MovieController::class, 'detail'])->name('movies.detail');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
// Route::get('/favorites/list',        [FavoriteController::class, 'list']);
// Route::post('/favorites/add',        [FavoriteController::class, 'add']);
Route::delete('/favorites/{imdbId}', [FavoriteController::class, 'destroy']);

Route::get('/movies2', function () {
    return view('testing');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
