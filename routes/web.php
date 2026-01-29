<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Student\PostulacionController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

use App\Http\Controllers\PortalSelectorController;

use App\Http\Controllers\Kits\KitDashboardController;
use App\Http\Controllers\Kits\KitRegistroController;
use App\Http\Controllers\Kits\KitArchivoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('home'))->name('home');

// ✅ Portal intent (SIN auth) - guarda intención y manda a login si no hay sesión
Route::get('/portal/{portal}', [PortalSelectorController::class, 'select'])
    ->name('portal.select');

Route::get('/entrar/{portal}', function (Request $request, string $portal) {
    abort_unless(in_array($portal, ['kits', 'postulantes']), 404);

    // guarda el portal elegido para usarlo después del login
    session(['portal_intended' => $portal]);

    return redirect()->route('login');
})->name('portal.entrar');

// ✅ Ruta para decidir a dónde ir después de login (según rol/portal)
Route::middleware('auth')->get('/redirect-portal', function () {
    $user = auth()->user();

    // Admin / Gerencia / Coordinación → Filament
    if (($user->is_admin ?? false) || $user->hasRole('gerente') || $user->hasRole('coordinador')) {
        return redirect('/admin');
    }

    // Si no hay portal en sesión, manda a un portal por defecto (o puedes redirigir a tu selector UI)
    $portal = session('portal', 'postulantes');

    return $portal === 'kits'
        ? redirect()->route('kits.dashboard')
        : redirect()->route('student.dashboard');
})->name('redirect.portal');


Route::get('/dashboard', function () {
    $user = auth()->user();

    if (($user->is_admin ?? false) || $user->hasRole(['gerente','coordinador'])) {
        return redirect('/admin');
    }

    if (session()->has('portal_intent')) {
        $portal = session()->pull('portal_intent'); // saca y borra
        $user->portal = $portal;
        $user->save();

        return redirect()->route($portal === 'kits' ? 'kits.dashboard' : 'student.dashboard');
    }

    if (! $user->portal) {
        return redirect()->route('portal.selector');
    }

    return redirect()->route($user->portal === 'kits' ? 'kits.dashboard' : 'student.dashboard');
})->middleware(['auth'])->name('dashboard');


// ✅ Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/seleccionar-portal', [PortalSelectorController::class, 'index'])->name('portal.selector');
    Route::post('/seleccionar-portal', [PortalSelectorController::class, 'store'])->name('portal.selector.store');
});

Route::get('/portal/{portal}', [PortalSelectorController::class, 'select'])->name('portal.select');

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Portal Postulantes (separado de Kits)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'portal:postulantes'])
    ->prefix('mi-portal')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        Route::get('/postulaciones', [PostulacionController::class, 'index'])->name('postulaciones.index');
        Route::get('/postulaciones/create', [PostulacionController::class, 'create'])->name('postulaciones.create');
        Route::post('/postulaciones', [PostulacionController::class, 'store'])->name('postulaciones.store');
        Route::get('/postulaciones/{postulacion}', [PostulacionController::class, 'show'])->name('postulaciones.show');
        Route::get('/postulaciones/{postulacion}/edit', [PostulacionController::class, 'edit'])->name('postulaciones.edit');
        Route::put('/postulaciones/{postulacion}', [PostulacionController::class, 'update'])->name('postulaciones.update');
        Route::middleware(['auth', 'portal:postulantes'])
        ->get('/mi-portal/postulaciones/{postulacion}/archivo/{campo}', [PostulacionController::class, 'viewFile'])
        ->name('student.postulaciones.file');
        Route::get('/postulaciones/{postulacion}/file/{field}', [PostulacionController::class, 'file'])
    ->name('postulaciones.file');   
        });

/*
|--------------------------------------------------------------------------
| Portal Kits (separado de Postulantes)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'portal:kits'])
    ->prefix('mi-portal-kits')
    ->name('kits.')
    ->group(function () {

        Route::get('/dashboard', [KitDashboardController::class, 'index'])->name('dashboard');

        Route::get('/registros', [KitRegistroController::class, 'index'])->name('registros.index');
        Route::get('/registros/create', [KitRegistroController::class, 'create'])->name('registros.create');
        Route::post('/registros', [KitRegistroController::class, 'store'])->name('registros.store');
        Route::get('/registros/{registro}', [KitRegistroController::class, 'show'])->name('registros.show');
        Route::get('/registros/{registro}/edit', [KitRegistroController::class, 'edit'])->name('registros.edit');
        Route::put('/registros/{registro}', [KitRegistroController::class, 'update'])->name('registros.update');
    });

/*
|--------------------------------------------------------------------------
| Archivos Kits (PDF) - accesibles por dueño o roles (controlado en controller)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('kits/archivos')
    ->name('kits.archivos.')
    ->group(function () {

        Route::get('/{registro}/documento', [KitArchivoController::class, 'documento'])->name('documento');
        Route::get('/{registro}/certificado', [KitArchivoController::class, 'certificado'])->name('certificado');
    });
