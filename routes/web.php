<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'cadet' => redirect()->route('cadet.dashboard'),
        'instructor' => redirect()->route('instructor.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => abort(403),
    };
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cadet/dashboard', function () {
        return view('cadet.dashboard');
    })->name('cadet.dashboard');

    Route::get('/instructor/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
