<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NegocioController;
use Illuminate\Http\Request;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\BookingController;

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

//pagina publica de detalle de negocio
Route::get('/negocio/{id}', [NegocioController::class, 'show'])->name('negocio.show');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS POR ESTADO DE NEGOCIO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.session', 'inject.api.token'])->group(function () {
 // 1. Rutas de transición (Registro y Espera)
    Route::get('/completar-negocio', [RegistrarController::class, 'showRegistroNegocio'])->name('registro.negocio.paso2');
    Route::post('/completar-negocio', [RegistrarController::class, 'storeNegocio'])->name('registro.negocio.save');
    Route::get('/registro/espera', [RegistrarController::class, 'showEsperandoValidacion'])->name('registro.negocio.espera');
});

Route::middleware(['auth.session', 'inject.api.token', 'check.business'])->group(function () {

   
    // 2. Panel de Admin (Solo entran si el middleware CheckBusinessSuscripcion los deja pasar)
    Route::middleware(['role:admin'])
        ->prefix('business')
        ->name('business.')
        ->group(function () {
            Route::get('/profile', [BusinessProfileController::class, 'index'])->name('profile');
            Route::post('/update', [BusinessProfileController::class, 'update'])->name('update');
            
            // Servicios
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Empleados
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| PANEL SUPERUSUARIO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'inject.api.token', 'role:superusuario'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Negocios
        Route::get('/businesses', [DashboardController::class, 'businesses'])->name('businesses');
        Route::get('/businesses/{id}', [DashboardController::class, 'businessDetail'])->name('businesses.show');
        // Si usas controladores tipo API o normales, añade esta línea:
        Route::patch('/businesses/{id}/status', [App\Http\Controllers\DashboardController::class, 'updateStatus'])
            ->name('businesses.updateStatus');

        // Promociones y Avisos
        Route::get('/promotions', [DashboardController::class, 'promotions'])->name('promotions');
        Route::get('/notices', [DashboardController::class, 'notices'])->name('notices');

        // Planes (CRUD)
        Route::get('/planes', [DashboardController::class, 'planes'])->name('planes.index');
        Route::post('/planes', [DashboardController::class, 'storePlan'])->name('planes.store');
        Route::put('/planes/{id}', [DashboardController::class, 'updatePlan'])->name('planes.update');
        Route::delete('/planes/{id}', [DashboardController::class, 'destroyPlan'])->name('planes.destroy');

        // Avisos / Notificaciones
        Route::get('/notices', [DashboardController::class, 'notices'])->name('notices');
        Route::post('/notices', [DashboardController::class, 'storeNotice'])->name('notices.store');

        // Ruta para asignar un plan a un negocio (si es necesario)
        Route::post('/planes/asignar', [App\Http\Controllers\DashboardController::class, 'assignPlan'])
            ->name('plans.assign');

        // Suscripciones (Lógica de Pagos)
        // Quitamos el prefijo 'dashboard/' de aquí porque el grupo principal ya lo pone
        Route::prefix('suscripciones')->name('subscriptions.')->group(function () {
            // Esta es para la lista general si la necesitas
            Route::get('/pendientes', [DashboardController::class, 'pendingSubscriptions'])->name('pending');
            // Rutas para la gestión de suscripciones (Activación y Rechazo)
            Route::post('/{id}/activar', [DashboardController::class, 'activateSubscription'])->name('subscriptions.activate');
            Route::post('/{id}/rechazar', [DashboardController::class, 'rejectSubscription'])->name('subscriptions.reject');
            Route::post('/verificar-vencimientos', [DashboardController::class, 'verificarVencimientos'])->name('verificar');

        });
    });

/*
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
            'year' => $prevDate->year,
        ]),

        'nextLink' => route('booking.availability', [
            'month' => $nextDate->month,
            'year' => $nextDate->year,
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
| UNIVERSAL PROXY (V2)
|--------------------------------------------------------------------------
*/

// Proxy Público (sin sesión)
Route::any('/api-proxy/public/{endpoint}', [\App\Http\Controllers\ProxyController::class, 'handlePublic'])
    ->where('endpoint', '.*')
    ->name('api.proxy.public');

// Proxy Protegido (con sesión)
Route::middleware(['auth.session'])->group(function () {
    Route::any('/api-proxy/{endpoint}', [\App\Http\Controllers\ProxyController::class, 'handle'])
        ->where('endpoint', '.*')
        ->name('api.proxy.protected');
});

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
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

/*
|-------------------------------------------------------------------------
| RUTA DE CALLBACK GOOGLE
|-------------------------------------------------------------------------
*/

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);

Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

/*
|--------------------------------------------------------------------------
| 🆕 NUEVAS RUTAS PARA AGENDAR CITAS (Booking)
|--------------------------------------------------------------------------
*/

// Rutas para agendar citas (protegidas con autenticación)
Route::middleware(['auth.session', 'inject.api.token'])->group(function () {
    // Página para agendar cita
    Route::get('/agendar-cita', [BookingController::class, 'create'])->name('booking.create');
    
    // Mis citas del cliente
    Route::get('/mis-citas', [BookingController::class, 'misCitas'])->name('booking.mis-citas');
});

// Rutas AJAX (proxy) para booking
Route::middleware(['auth.session', 'inject.api.token'])->prefix('api-proxy')->group(function () {
    // Disponibilidad de empleado
    Route::get('/disponibilidad/empleado/{id}', [BookingController::class, 'disponibilidad']);
    
    // Crear cita
    Route::post('/citas', [BookingController::class, 'store']);
});

/*Rutas de completar registro de negocio
Route::middleware(['auth.session'])->group(function () {
    Route::get('/completar-negocio', function () {
        return view('business.profile.onboarding-negocio');
    })->name('business.complete');
});
*/