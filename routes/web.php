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

Route::get('/booking/availability', function () {
    Carbon\Carbon::setLocale('es');
    
    // Get requested date or default to now
    $year = request('year', now()->year);
    $month = request('month', now()->month);
    
    $date = Carbon\Carbon::createFromDate($year, $month, 1);
    $now = Carbon\Carbon::now();

    // Navigation
    $prevDate = $date->copy()->subMonth();
    $nextDate = $date->copy()->addMonth();

    return view('booking.availability', [
        'monthName' => ucfirst($date->translatedFormat('F')),
        'year' => $date->year,
        'month' => $date->month,
        'daysInMonth' => $date->daysInMonth,
        'firstDayOfWeek' => $date->dayOfWeek, 
        
        // Date Limits
        'now' => $now->startOfDay(), // Pass full Carbon object
        'maxDate' => $now->copy()->addDays(30)->endOfDay(),
        
        // Navigation Links
        'prevLink' => route('booking.availability', ['month' => $prevDate->month, 'year' => $prevDate->year]),
        'nextLink' => route('booking.availability', ['month' => $nextDate->month, 'year' => $nextDate->year]),
    ]);
})->name('booking.availability');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/dashboard/businesses', function () {
    return view('dashboard.businesses.index');
})->name('dashboard.businesses');

Route::get('/dashboard/businesses/{id}', function ($id) {
    return view('dashboard.businesses.show', ['id' => $id]);
})->name('dashboard.businesses.show');

Route::get('/dashboard/promotions', function () {
    return view('dashboard.promotions.index');
})->name('dashboard.promotions');

Route::get('/dashboard/notices', function () {
    return view('dashboard.notices.index');
})->name('dashboard.notices');

use App\Http\Controllers\AuthController;

Route::post('/proxy/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('welcome');
});
