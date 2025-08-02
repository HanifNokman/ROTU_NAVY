<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Instructor\PendingVerificationController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\Cadet\CadetDashboardController;
use App\Http\Controllers\Instructor\LearningHubController as InstructorLearningHubController;
use App\Http\Controllers\Cadet\LearningHubController as CadetLearningHubController;
use App\Http\Controllers\Instructor\CadetManagementController;
use App\Http\Controllers\Instructor\InventoryController as InstructorInventoryController;
use App\Http\Controllers\Cadet\InventoryController as CadetInventoryController;

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

    // Updated Instructor Cadet Management Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/instructor/cadet_management', [CadetManagementController::class, 'index'])->name('instructor.cadet_management');
        Route::get('/instructor/cadets/{cadet}', [CadetManagementController::class, 'show'])->name('instructor.cadets.show');
        Route::post('/instructor/cadets/positions', [CadetManagementController::class, 'updatePositions'])->name('instructor.cadets.positions.update');
        Route::post('/instructor/cadets/swimming/mark-passed', [CadetManagementController::class, 'markSwimmingPassed'])->name('instructor.cadets.swimming.mark-passed');
        Route::delete('/instructor/cadets/{cadet}', [CadetManagementController::class, 'destroy'])->name('instructor.cadets.destroy');
    });

    // Training route
    Route::get('/instructor/training', function () {
        return view('instructor.training');
    })->name('instructor.training');

    // Allowance route
    Route::get('/instructor/allowance', function () {
        return view('instructor.allowance');
    })->name('instructor.allowance');

    // Inventory route
    Route::get('/instructor/inventory', [InstructorInventoryController::class, 'index'])->name('instructor.inventory');

    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/inventory', [InstructorInventoryController::class, 'index'])->name('inventory');
    Route::patch('/inventory/loan/{loan}', [InstructorInventoryController::class, 'updateLoanStatus'])->name('inventory.update-loan');
    Route::get('/inventory/export/uniforms', [InstructorInventoryController::class, 'exportUniformSizes'])->name('inventory.export.uniforms');
    Route::get('/inventory/export/loans', [InstructorInventoryController::class, 'exportEquipmentLoans'])->name('inventory.export.loans');
});

    // Learning Hub route
    Route::get('/instructor/learning_hub', [InstructorLearningHubController::class, 'index'])->name('instructor.learning_hub');

    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
        // Learning Materials routes
        Route::get('/learning-materials', [InstructorLearningHubController::class, 'index'])->name('learning_materials');
        Route::post('/learning-materials', [InstructorLearningHubController::class, 'store'])->name('learning_materials.store');
        Route::get('/learning-materials/{material}/edit', [InstructorLearningHubController::class, 'edit'])->name('learning_materials.edit');
        Route::put('/learning-materials/{material}', [InstructorLearningHubController::class, 'update'])->name('learning_materials.update');
        Route::delete('/learning-materials/{material}', [InstructorLearningHubController::class, 'destroy'])->name('learning_materials.destroy');

        // Category routes
        Route::post('/categories', [InstructorLearningHubController::class, 'storeCategory'])->name('learning_material_categories.store');
        Route::delete('/categories/{category}', [InstructorLearningHubController::class, 'destroyCategory'])->name('learning_material_categories.destroy');
    });

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

    Route::get('/cadet/learning_hub', [CadetLearningHubController::class, 'index'])->name('cadet.learning_hub');

    // Cadet Inventory
    Route::get('/cadet/inventory', [CadetInventoryController::class, 'index'])->name('cadet.inventory');

    Route::middleware('auth')->prefix('cadet')->name('cadet.')->group(function () {
    Route::get('/inventory', [CadetInventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/profile', [CadetInventoryController::class, 'myProfile'])->name('inventory.profile');
    Route::post('/inventory/uniform-size', [CadetInventoryController::class, 'updateUniformSize'])->name('inventory.uniform-size.update');
    Route::delete('/inventory/uniform-size/{cadetSize}', [CadetInventoryController::class, 'deleteUniformSize'])->name('inventory.uniform-size.delete');
    Route::post('/inventory/loan', [CadetInventoryController::class, 'createLoan'])->name('inventory.loan.create');
    Route::patch('/inventory/loan/{loan}/return', [CadetInventoryController::class, 'returnLoan'])->name('inventory.loan.return');
});

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

Route::post('/instructor/increment-duty', [InstructorDashboardController::class, 'incrementDuty'])->name('instructor.incrementDuty');

Route::middleware(['auth', 'verified', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/learning-materials', [InstructorLearningHubController::class, 'index'])->name('learning_materials');
});

require __DIR__.'/auth.php';
