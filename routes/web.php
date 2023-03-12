<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guest');

Route::get('/dashboard', function() {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

Route::get('accounts', [AccountController::class, 'index'])
    ->middleware('auth')
    ->name('accounts.index');
Route::post('accounts', [AccountController::class, 'store'])
    ->middleware('auth')
    ->name('accounts.store');
Route::get('accounts/create', [AccountController::class, 'create'])
    ->middleware('auth')
    ->name('accounts.create');
Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
    ->middleware('auth')
    ->name('accounts.edit');
Route::get('accounts/{account}', [AccountController::class, 'show'])
    ->middleware('auth')
    ->name('accounts.show');
Route::put('accounts/{account}', [AccountController::class, 'update'])
    ->middleware('auth')
    ->name('accounts.update');
Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
    ->middleware('auth')
    ->name('accounts.destroy');
Route::get('contacts', [ContactController::class, 'index'])
    ->middleware('auth')
    ->name('contacts.index');
Route::post('contacts', [ContactController::class, 'store'])
    ->middleware('auth')
    ->name('contacts.store');
Route::get('contacts/create', [ContactController::class, 'create'])
    ->middleware('auth')
    ->name('contacts.create');
Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])
    ->middleware('auth')
    ->name('contacts.edit');
Route::get('contacts/{contact}', [ContactController::class, 'show'])
    ->middleware('auth')
    ->name('contacts.show');
Route::put('contacts/{contact}', [ContactController::class, 'update'])
    ->middleware('auth')
    ->name('contacts.update');
Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])
    ->middleware('auth')
    ->name('contacts.destroy');

require __DIR__.'/auth.php';
