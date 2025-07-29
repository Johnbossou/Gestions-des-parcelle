<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/password/reset', [AuthController::class, 'showPasswordResetForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});
Route::middleware(['auth', 'permission:export-parcels'])->group(function () {
    Route::get('/parcelles/export', [ParcelleController::class, 'export'])
        ->name('parcelles.export');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [ParcelleController::class, 'index'])->name('dashboard')->middleware('permission:view-parcels');
    Route::get('/parcelles', [ParcelleController::class, 'index'])->name('parcelles.index')->middleware('permission:view-parcels');
    Route::get('/parcelles/create', [ParcelleController::class, 'create'])->name('parcelles.create')->middleware('permission:create-parcelles');
    Route::post('/parcelles', [ParcelleController::class, 'store'])->name('parcelles.store')->middleware('permission:create-parcelles');
    Route::get('/parcelles/{parcelle}', [ParcelleController::class, 'show'])->name('parcelles.show')->middleware('permission:view-parcels');
    Route::get('/parcelles/{parcelle}/edit', [ParcelleController::class, 'edit'])->name('parcelles.edit')->middleware('permission:edit-parcelles');
    Route::put('/parcelles/{parcelle}', [ParcelleController::class, 'update'])->name('parcelles.update')->middleware('permission:edit-parcelles');
    Route::delete('/parcelles/{parcelle}', [ParcelleController::class, 'destroy'])->name('parcelles.destroy')->middleware('permission:delete-parcels');
    Route::get('/parcelles/{parcelle}/coordinates', [ParcelleController::class, 'editCoordinates'])->name('parcelles.coordinates')->middleware('permission:edit-coordinates');
    Route::put('/parcelles/{parcelle}/coordinates', [ParcelleController::class, 'updateCoordinates'])->name('parcelles.coordinates.update')->middleware('permission:edit-coordinates');
    Route::get('/parcelles/export', [ParcelleController::class, 'export'])->name('parcelles.export')->middleware('permission:export-parcels');
    Route::get('/parcelles/filter', [ParcelleController::class, 'filter'])->name('parcelles.filter')->middleware('permission:view-parcels');
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:manage-users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:manage-users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:manage-users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:manage-users');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:manage-users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:manage-users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/update', [UserController::class, 'changePassword'])->name('password.update');
});
