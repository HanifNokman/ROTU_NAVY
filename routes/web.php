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
    // Instructor Dashboard
    Route::get('/instructor/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');

    // Instructor Cadet Management
    Route::get('/instructor/cadet_management', function () {
        return view('instructor.cadet_management');
    })->name('instructor.cadet_management');

    // Training route
    Route::get('/instructor/training', function () {
        return view('instructor.training');
    })->name('instructor.training');

    // Allowance route
    Route::get('/instructor/allowance', function () {
        return view('instructor.allowance');
    })->name('instructor.allowance');

    // Inventory route
    Route::get('/instructor/inventory', function () {
        return view('instructor.inventory');
    })->name('instructor.inventory');

    // Learning Hub route
    Route::get('/instructor/learning-hub', function () {
        return view('instructor.learning-hub');
    })->name('instructor.learning-hub');

    // Gallery route
    Route::get('/instructor/gallery', function () {
        return view('instructor.gallery');
    })->name('instructor.gallery');

    // Pending Verification route
    Route::get('/instructor/pending-verification', function () {
        return view('instructor.pending-verification');
    })->name('pending.verification');

    // Cadet Dashboard
    Route::get('/cadet/dashboard', function () {
        return view('cadet.dashboard');
    })->name('cadet.dashboard');

    // Cadet Management
    // Cadet Training
    Route::get('/cadet/training', function () {
        return view('cadet.training');
    })->name('cadet.training');

    // Cadet Allowance
    Route::get('/cadet/allowance', function () {
        return view('cadet.allowance');
    })->name('cadet.allowance');

    // Cadet Learning Hub
    Route::get('/cadet/learning_hub', function () {
        return view('cadet.learning_hub');
    })->name('cadet.learning_hub');

    // Cadet Inventory
    Route::get('/cadet/inventory', function () {
        return view('cadet.inventory');
    })->name('cadet.inventory');

    // Cadet Gallery
    Route::get('/cadet/gallery', function () {
        return view('cadet.gallery');
    })->name('cadet.gallery');

    // Cadet Pending Verification
    Route::get('/cadet/attendance', function () {
        return view('cadet.attendance');
    })->name('cadet.attendance');

    // Admin Dashboard
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
