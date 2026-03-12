<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/movies', function () {
    return view('movies');
});

Route::get('/favorites', function () {
    return view('favorites');
});

Route::get('/movies2', function () {
    return view('testing');
});
