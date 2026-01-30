<?php

use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('auth.role-selection');
})->name('register.role-selection');

Route::get('/register/business', function () {
    return view('auth.register-business');
})->name('register.business');

Route::get('/register/client', function () {
    return view('auth.register-client');
})->name('register.client');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/business/profile', function () {
    return view('business.profile');
})->name('business.profile');

Route::get('/business/view', function () {
    return view('business.view');
})->name('business.show');

Route::get('/service/view', function () {
    return view('service.view');
})->name('service.show');

Route::get('/', function () {
    return view('welcome');
});
