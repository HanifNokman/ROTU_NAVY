<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendingVerificationController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\Cadet\CadetDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/logout-and-landing', function () {
    \Auth::logout();
    return redirect('/');
})->name('logout.and.landing');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    if ($user->status !== 'accepted') {
        \Auth::logout();
        return redirect('/')->with('error', 'Your account is not accepted.');
    }
    switch ($user->role) {
        case 'cadet':
            return redirect()->route('cadet.dashboard');
        case 'instructor':
            return redirect()->route('instructor.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        default:
            abort(403);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Instructor Dashboard
    Route::get('/instructor/dashboard', function () {
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
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
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
        return view('instructor.learning-hub');
    })->name('instructor.learning-hub');

    // Gallery route
    Route::get('/instructor/gallery', function () {
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
        return view('instructor.gallery');
    })->name('instructor.gallery');

    // Pending Verification routes
    Route::get('/instructor/pending-verification', [PendingVerificationController::class, 'index'])->name('pending.verification');
    Route::post('/instructor/pending-verification/{user}/accept', [PendingVerificationController::class, 'accept'])->name('pending.verification.accept');
    Route::post('/instructor/pending-verification/{user}/reject', [PendingVerificationController::class, 'reject'])->name('pending.verification.reject');

    Route::get('/awaiting-approval', function () {
        return view('auth.awaiting-approval');
    })->name('awaiting.approval');

    // Cadet Dashboard
    Route::get('/cadet/dashboard', function () {
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
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
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/personal', [ProfileController::class, 'updatePersonal'])->name('profile.personal.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/update-personal-info', [PersonalInfoController::class, 'edit'])->name('personal.edit');
    Route::patch('/update-personal-info', [PersonalInfoController::class, 'update'])->name('personal.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cadet/dashboard', [CadetDashboardController::class, 'index'])->name('cadet.dashboard');
});

require __DIR__.'/auth.php';
