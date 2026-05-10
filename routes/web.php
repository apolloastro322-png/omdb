<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
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

Route::get('/movies', function () {
    return view('movies');
});

Route::get('/favorites', function () {
    return view('favorites');
});

Route::get('/movies2', function () {
    return view('testing');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
