<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('backend.layouts.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/v1/auth.php';
require __DIR__ . '/v1/user.php';
require __DIR__ . '/v1/settings/mail.php';
