<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('backend.layouts.dashboard.index');
})->name('dashboard');

require 'v1/auth.php';
require 'v1/user.php';
require 'v1/settings/mail.php';
