<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AuthController;


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

Route::get('/business/view', function () {
    return view('business.view');
})->name('business.show');



//** API Routes for business services management*/
Route::middleware('role:admin')
    ->prefix('business')
    ->name('business.')
    ->group(function () {

        Route::get('/profile', [ServiceController::class, 'index'])
            ->name('profile');

        Route::post('/services', [ServiceController::class, 'store'])
            ->name('services.store');

        Route::put('/services/{id}', [ServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])
            ->name('services.destroy');

});

//** Api routes for super */
Route::middleware('role:superusuario')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        Route::get('/', function () {
            return view('dashboard.index');
        })->name('index');

        Route::get('/promotions', function () {
    return view('dashboard.promotions.index');
})->name('promotions');

Route::get('/notices', function () {
    return view('dashboard.notices.index');
})->name('notices');

        Route::get('/businesses', function () {
            return view('dashboard.businesses.index');
        })->name('businesses');
});
//

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

Route::post('/proxy/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/logout', function () {
    session()->flush();   // elimina todo
    return redirect('/'); // vuelve a welcome
});

Route::post('/proxy/register-client', [AuthController::class, 'registerCliente']);

Route::post('/proxy/register-admin', [AuthController::class, 'registerAdmin']);