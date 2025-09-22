
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\Instructor\PendingVerificationController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\Cadet\CadetDashboardController;
use App\Http\Controllers\Instructor\LearningHubController as InstructorLearningHubController;
use App\Http\Controllers\Cadet\LearningHubController as CadetLearningHubController;
use App\Http\Controllers\Instructor\CadetManagementController;
use App\Http\Controllers\Instructor\InventoryController as InstructorInventoryController;
use App\Http\Controllers\Cadet\InventoryController as CadetInventoryController;
use App\Http\Controllers\Instructor\GalleryController as InstructorGalleryController;
use App\Http\Controllers\Cadet\GalleryController as CadetGalleryController;
use App\Http\Controllers\Instructor\TrainingController as InstructorTrainingController;
use App\Http\Controllers\Cadet\TrainingController as CadetTrainingController;
use App\Http\Controllers\Instructor\AllowanceController;
use App\Http\Controllers\Cadet\AttendanceController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Content Management Routes (Protected by middleware)
Route::middleware(['auth'])->group(function () {
    
    // Update content settings (only instructors and admins)
    Route::post('/content-management/update', [ContentManagementController::class, 'update'])
        ->name('content.update');
    
    // Reset content to defaults (only instructors and admins)
    Route::post('/content-management/reset', [ContentManagementController::class, 'resetToDefaults'])
        ->name('content.reset');
});

// Public API routes for getting current settings
Route::get('/api/content-settings', [ContentManagementController::class, 'getCurrentSettings'])
    ->name('api.content.settings');

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
    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
    // Main training page
    Route::get('/training', [InstructorTrainingController::class, 'index'])->name('training');
    
    // CRUD operations
    Route::post('/training', [InstructorTrainingController::class, 'store'])->name('training.store');
    Route::get('/training/{training}', [InstructorTrainingController::class, 'show'])->name('training.show');
    Route::put('/training/{training}', [InstructorTrainingController::class, 'update'])->name('training.update');
    Route::delete('/training/{training}', [InstructorTrainingController::class, 'destroy'])->name('training.destroy');
    
    // New endpoints for additional features
    Route::post('/training/{training}/end', [InstructorTrainingController::class, 'endTraining'])->name('training.end');
    Route::get('/training/{training}/qr-code', [InstructorTrainingController::class, 'generateQrCode'])->name('training.qr-code');
    Route::get('/training/{training}/cadets', [InstructorTrainingController::class, 'getCadetsForAttendance'])->name('training.cadets');
    
    // Attendance management
    Route::post('/training/{training}/attendance', [InstructorTrainingController::class, 'saveAttendance'])->name('training.attendance');
    Route::post('/training/{training}/attendance/qr', [InstructorTrainingController::class, 'recordQrAttendance'])->name('training.attendance.qr');
    Route::get('/attendance-list', [InstructorTrainingController::class, 'getAllAttendanceList'])->name('attendance.list.all');
    // AJAX endpoints for instructor attendance filters (updated)
    Route::get('/getYears', [InstructorTrainingController::class, 'getYears']);
    Route::get('/getMonths', [InstructorTrainingController::class, 'getMonths']);
    Route::get('/getCadetAttendanceList', [InstructorTrainingController::class, 'getCadetAttendanceList']);
    });

    // Allowance route
    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/allowance', [AllowanceController::class, 'index'])->name('allowance');
        Route::get('/allowance/training/{training}/details', [AllowanceController::class, 'getTrainingDetails'])->name('allowance.training.details');
    });

    // Inventory route
    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
        
        // Main inventory page
        Route::get('/inventory', [InstructorInventoryController::class, 'index'])->name('inventory');
        
        // Uniform Type routes
        Route::post('/inventory/uniform-types', [InstructorInventoryController::class, 'storeUniformType'])->name('inventory.uniform-types.store');
        Route::get('/inventory/uniform-types', [InstructorInventoryController::class, 'getUniformTypes'])->name('inventory.uniform-types.index');
        Route::delete('/inventory/uniform-types/{id}', [InstructorInventoryController::class, 'deleteUniformType'])->name('inventory.uniform-types.destroy');
        
        // Uniform Component routes
        Route::post('/inventory/uniform-components', [InstructorInventoryController::class, 'storeUniformComponent'])->name('inventory.uniform-components.store');
        Route::get('/inventory/uniform-components', [InstructorInventoryController::class, 'getUniformComponents'])->name('inventory.uniform-components.index');
        Route::delete('/inventory/uniform-components/{id}', [InstructorInventoryController::class, 'deleteUniformComponent'])->name('inventory.uniform-components.destroy');
        Route::get('/inventory/uniform-types/{uniformTypeId}/components', [InstructorInventoryController::class, 'getComponentsByType'])->name('inventory.components-by-type');
        
        // Equipment routes
        Route::post('/inventory/equipment', [InstructorInventoryController::class, 'storeEquipment'])->name('inventory.equipment.store');
        Route::get('/inventory/equipment', [InstructorInventoryController::class, 'getEquipment'])->name('inventory.equipment.index');
        Route::delete('/inventory/equipment/{id}', [InstructorInventoryController::class, 'deleteEquipment'])->name('inventory.equipment.destroy');
        
        // Loan management
        Route::patch('/inventory/loans/{loan}', [InstructorInventoryController::class, 'updateLoanStatus'])->name('inventory.update-loan');
        
        // Export routes
        Route::get('/inventory/export/uniforms', [InstructorInventoryController::class, 'exportUniformSizes'])->name('inventory.export.uniforms');
        Route::get('/inventory/export/loans', [InstructorInventoryController::class, 'exportEquipmentLoans'])->name('inventory.export.loans');
        Route::get('/inventory/export/uniform-summary', [InstructorInventoryController::class, 'exportUniformSizeSummary'])->name('inventory.export.uniform-summary');
    });

    // Learning Hub routes
    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
        // Main learning hub page
        Route::get('/learning_hub', [InstructorLearningHubController::class, 'index'])->name('learning_hub');
        
        // Learning Materials routes
        Route::post('/learning-materials', [InstructorLearningHubController::class, 'store'])->name('learning_materials.store');
        Route::get('/learning-materials/{material}/edit', [InstructorLearningHubController::class, 'edit'])->name('learning_materials.edit');
        Route::put('/learning-materials/{material}', [InstructorLearningHubController::class, 'update'])->name('learning_materials.update');
        Route::delete('/learning-materials/{material}', [InstructorLearningHubController::class, 'destroy'])->name('learning_materials.destroy');

        // Category routes
        Route::post('/categories', [InstructorLearningHubController::class, 'storeCategory'])->name('learning_material_categories.store');
        Route::delete('/categories/{category}', [InstructorLearningHubController::class, 'destroyCategory'])->name('learning_material_categories.destroy');
    });

    // Gallery routes - FIXED
    Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function () {
        
        // Gallery routes - Using the correct controller
        Route::get('/gallery', [InstructorGalleryController::class, 'index'])->name('gallery');
        Route::post('/gallery', [InstructorGalleryController::class, 'store'])->name('gallery.store');
        Route::put('/gallery/{gallery}', [InstructorGalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{gallery}', [InstructorGalleryController::class, 'destroy'])->name('gallery.destroy');
        
        // Gallery category routes
        Route::post('/gallery-categories', [InstructorGalleryController::class, 'storeCategory'])->name('gallery_categories.store');
        Route::delete('/gallery-categories/{category}', [InstructorGalleryController::class, 'destroyCategory'])->name('gallery_categories.destroy');
        
    });

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

    // Cadet Training
    Route::middleware('auth')->prefix('cadet')->name('cadet.')->group(function () {
        Route::get('/training', [CadetTrainingController::class, 'index'])->name('training');
        Route::get('/training/{training}', [CadetTrainingController::class, 'show'])
            ->whereNumber('training')
            ->name('training.show');
    });


    // Cadet Allowance
    Route::middleware('auth')->prefix('cadet')->name('cadet.')->group(function () {
    Route::get('/allowance', [\App\Http\Controllers\Cadet\AllowanceController::class, 'index'])->name('allowance');
    Route::get('/allowance/ajax', [\App\Http\Controllers\Cadet\AllowanceController::class, 'ajax'])->name('allowance.ajax');
    });

    // Cadet Learning Hub
    Route::get('/cadet/learning_hub', [CadetLearningHubController::class, 'index'])->name('cadet.learning_hub');

    // Cadet Inventory Routes
    Route::middleware('auth')->prefix('cadet')->name('cadet.')->group(function () {
        
        // Specific routes FIRST (order matters!)
        Route::delete('/inventory/uniform-size/{cadetSize}', [CadetInventoryController::class, 'deleteUniformSize'])->name('inventory.uniform-size.delete');
        Route::post('/inventory/uniform-size', [CadetInventoryController::class, 'updateUniformSize'])->name('inventory.uniform-size.update');
        
        // General routes AFTER
        Route::get('/inventory', [CadetInventoryController::class, 'index'])->name('inventory');
        Route::get('/inventory/profile', [CadetInventoryController::class, 'myProfile'])->name('inventory.profile');
        
        // Other routes...
        Route::get('/inventory/uniform-types/{uniformTypeId}/components', [CadetInventoryController::class, 'getComponentsByType'])->name('inventory.components-by-type');
        Route::post('/inventory/loan', [CadetInventoryController::class, 'createLoan'])->name('inventory.loan.create');
        Route::patch('/inventory/loan/{loan}/return', [CadetInventoryController::class, 'returnLoan'])->name('inventory.loan.return');
    });

    // Cadet Gallery
     Route::get('/cadet/gallery', [CadetGalleryController::class, 'index'])->name('cadet.gallery');

    // Cadet Attendance
    Route::get('/cadet/attendance', [AttendanceController::class, 'index'])->name('cadet.attendance');
    Route::post('/cadet/attendance/mark', [AttendanceController::class, 'markPresent'])->name('cadet.attendance.mark');
    Route::post('/cadet/attendance/absence/{attendance}', [AttendanceController::class, 'submitAbsence'])->name('cadet.attendance.absence');
    Route::post('/cadet/attendance/verify-qr', [AttendanceController::class, 'verifyQR'])->name('cadet.attendance.verify-qr');

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

require __DIR__.'/auth.php';