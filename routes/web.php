<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| PERFIL USUARIO
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');


/*
|--------------------------------------------------------------------------
| VISTAS PUBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/business/view', function () {
    return view('business.view');
})->name('business.show');

Route::get('/service/view', function () {
    return view('service.view');
})->name('service.show');


/*
|--------------------------------------------------------------------------
| PANEL ADMIN NEGOCIO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session','inject.api.token','role:admin'])
    ->prefix('business')
    ->name('business.')
    ->group(function () {

        // PERFIL DEL NEGOCIO
        Route::get('/profile', [BusinessProfileController::class, 'index'])
            ->name('profile');

        Route::post('/update', [BusinessProfileController::class, 'update'])
            ->name('update');


        /*
        |--------------------------------------------------------------------------
        | SERVICIOS
        |--------------------------------------------------------------------------
        */

        Route::post('/services', [ServiceController::class, 'store'])
            ->name('services.store');

        Route::put('/services/{id}', [ServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])
            ->name('services.destroy');


        /*
        |--------------------------------------------------------------------------
        | EMPLEADOS
        |--------------------------------------------------------------------------
        */

        Route::post('/employees', [EmployeeController::class, 'store'])
            ->name('employees.store');

        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
            ->name('employees.destroy');

        Route::put('/employees/{id}',[EmployeeController::class,'update'])
            ->name('employees.update');
});


/*
|--------------------------------------------------------------------------
| PANEL SUPERUSUARIO
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| CALENDARIO DISPONIBILIDAD
|--------------------------------------------------------------------------
*/

Route::get('/booking/availability', function () {

    Carbon::setLocale('es');

    $year = request('year', now()->year);
    $month = request('month', now()->month);

    $date = Carbon::createFromDate($year, $month, 1);
    $now = Carbon::now();

    $prevDate = $date->copy()->subMonth();
    $nextDate = $date->copy()->addMonth();

    return view('booking.availability', [
        'monthName' => ucfirst($date->translatedFormat('F')),
        'year' => $date->year,
        'month' => $date->month,
        'daysInMonth' => $date->daysInMonth,
        'firstDayOfWeek' => $date->dayOfWeek,

        'now' => $now->startOfDay(),
        'maxDate' => $now->copy()->addDays(30)->endOfDay(),

        'prevLink' => route('booking.availability', [
            'month' => $prevDate->month,
            'year' => $prevDate->year
        ]),

        'nextLink' => route('booking.availability', [
            'month' => $nextDate->month,
            'year' => $nextDate->year
        ]),
    ]);

})->name('booking.availability');


/*
|--------------------------------------------------------------------------
| AUTH PROXY
|--------------------------------------------------------------------------
*/

Route::post('/proxy/login', [AuthController::class, 'login']);

Route::post('/proxy/register-client', [AuthController::class, 'registerCliente']);

Route::post('/proxy/register-admin', [AuthController::class, 'registerAdmin']);


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/logout', function () {
    session()->flush();
    return redirect('/');
});


/*
|--------------------------------------------------------------------------
| RUTAS SOLO PARA INVITADOS
|--------------------------------------------------------------------------
*/

Route::middleware(['guest.session'])->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::get('/register', [AuthController::class, 'showRoleSelection'])->name('register');

    Route::get('/register/business', [AuthController::class, 'showBusinessRegister'])->name('register.business');

    Route::get('/register/client', [AuthController::class, 'showClientRegister'])->name('register.client');

});