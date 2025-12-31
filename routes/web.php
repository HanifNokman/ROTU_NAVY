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
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Api\BadgeController;

use Illuminate\Support\Facades\Route;

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/application', [ApplicationController::class, 'create'])->name('application.create');
Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
Route::get('/application/status', [ApplicationController::class, 'showStatus'])->name('application.status');
Route::post('/application/status/search', [ApplicationController::class, 'searchStatus'])->name('application.status.search');

Route::get('/about-me', function () {
    return view('about-me');
})->name('about-me');

Route::get('/gallery', [App\Http\Controllers\PublicGalleryController::class, 'index'])->name('public.gallery');
Route::get('/gallery/category/{categoryId}', [App\Http\Controllers\PublicGalleryController::class, 'getByCategory'])->name('public.gallery.category');

Route::get('/api/content-settings', [ContentManagementController::class, 'getCurrentSettings'])
    ->name('api.content.settings');

Route::get('/logout-and-landing', function () {
    \Auth::logout();
    return redirect('/');
})->name('logout.and.landing');

// ============================================================================
// AUTHENTICATED ROUTES
// ============================================================================

Route::middleware(['auth'])->group(function () {

    // ------------------------------------------------------------------------
    // Notification Routes
    // ------------------------------------------------------------------------

    Route::patch('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-read');

    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read');

    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');

    // ------------------------------------------------------------------------
    // Badge API Routes
    // ------------------------------------------------------------------------

    Route::get('/api/badges/pending', [BadgeController::class, 'getPendingBadges'])
        ->name('api.badges.pending');

    Route::post('/api/badges/{cadetBadgeId}/mark-displayed', [BadgeController::class, 'markAsDisplayed'])
        ->name('api.badges.mark-displayed');

    // Testing route - remove in production or protect with admin middleware
    Route::post('/api/badges/trigger-test', [BadgeController::class, 'triggerTestBadge'])
        ->name('api.badges.trigger-test');

    // Badge test page - remove in production
    Route::get('/badge-test', function () {
        return view('badge-test');
    })->name('badge.test');

    // ------------------------------------------------------------------------
    // Content Management Routes
    // ------------------------------------------------------------------------

    Route::post('/content-management/update', [ContentManagementController::class, 'update'])
        ->name('content.update');

    Route::post('/content-management/reset', [ContentManagementController::class, 'resetToDefaults'])
        ->name('content.reset');

    // ------------------------------------------------------------------------
    // Profile Routes
    // ------------------------------------------------------------------------
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/personal', [ProfileController::class, 'updatePersonal'])->name('profile.personal.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/update-personal-info', [PersonalInfoController::class, 'edit'])->name('personal.edit');
    Route::patch('/update-personal-info', [PersonalInfoController::class, 'update'])->name('personal.update');

    // ------------------------------------------------------------------------
    // Pending Verification (moved to instructor section below)
    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    // Application Management
    // ------------------------------------------------------------------------

    Route::get('/instructor/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/instructor/applications/{application}/update-status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');

    // ------------------------------------------------------------------------
    // Dashboard Routes
    // ------------------------------------------------------------------------
    
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
    })->middleware(['verified'])->name('dashboard');

    Route::get('/awaiting-approval', function () {
        return view('auth.awaiting-approval');
    })->name('awaiting.approval');

    // ------------------------------------------------------------------------
    // Alumni Route
    // ------------------------------------------------------------------------
    
    Route::get('/alumni', [App\Http\Controllers\AlumniController::class, 'index'])->name('alumni');

    // ------------------------------------------------------------------------
    // API Routes
    // ------------------------------------------------------------------------
    
    Route::post('/api/quiz/start', [CadetLearningHubController::class, 'startQuiz'])->name('api.quiz.start');
    Route::post('/api/quiz/submit', [CadetLearningHubController::class, 'submitQuiz'])->name('api.quiz.submit');
    Route::post('/api/quiz/results', [CadetLearningHubController::class, 'getQuizResults'])->name('api.quiz.results');
    Route::get('/api/cadet/top-scores', [CadetLearningHubController::class, 'getTopScores'])->name('api.cadet.top-scores');
    Route::get('/api/materials', [CadetLearningHubController::class, 'getMaterials'])->name('api.materials');
    Route::get('/api/instructors', [CadetLearningHubController::class, 'getInstructors'])->name('api.instructors');
    Route::get('/api/instructor/{instructor}', [CadetLearningHubController::class, 'getInstructor'])->name('api.instructor');
    Route::get('/api/unlocked-difficulties', [CadetLearningHubController::class, 'getUnlockedDifficultiesAjax'])->name('api.unlocked-difficulties');
});

// ============================================================================
// INSTRUCTOR ROUTES
// ============================================================================

Route::middleware(['auth', 'verified'])->prefix('instructor')->name('instructor.')->group(function () {
    
    // ------------------------------------------------------------------------
    // Instructor Dashboard
    // ------------------------------------------------------------------------

    Route::match(['get', 'post'], '/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
    Route::post('/increment-duty', [InstructorDashboardController::class, 'incrementDuty'])->name('incrementDuty');

    // ------------------------------------------------------------------------
    // Pending Verification
    // ------------------------------------------------------------------------

    Route::get('/pending-verification', [PendingVerificationController::class, 'index'])
        ->name('pending.verification');

    Route::post('/pending-verification/accept/{user}', [PendingVerificationController::class, 'accept'])
        ->name('pending.verification.accept');

    Route::post('/pending-verification/reject/{user}', [PendingVerificationController::class, 'reject'])
        ->name('pending.verification.reject');

    Route::post('/pending-verification/accept-all', [PendingVerificationController::class, 'acceptAll'])
        ->name('pending.verification.accept-all');

    Route::post('/pending-verification/reject-all', [PendingVerificationController::class, 'rejectAll'])
        ->name('pending.verification.reject-all');

    // NEW ROUTES FOR SELECTION MODE
    Route::post('/pending-verification/update-step', [PendingVerificationController::class, 'updateApplicationStep'])
        ->name('pending.verification.update-step');

    Route::post('/pending-verification/end-selection', [PendingVerificationController::class, 'endSelection'])
        ->name('pending.verification.end-selection');

    // ------------------------------------------------------------------------
    // Cadet Management
    // ------------------------------------------------------------------------
    
    Route::get('/cadet_management', [CadetManagementController::class, 'index'])->name('cadet_management');
    
    // === ADD THESE 5 NEW AJAX ROUTES ===
    Route::get('/cadets/ajax', [CadetManagementController::class, 'getCadetsAjax'])->name('cadets.ajax');
    Route::get('/cadets/best-cadets', [CadetManagementController::class, 'getBestCadetsAjax'])->name('cadets.best');
    Route::get('/cadets/best-academic', [CadetManagementController::class, 'getBestAcademicCadetsAjax'])->name('cadets.best_academic');
    Route::get('/cadets/suspended', [CadetManagementController::class, 'getSuspendedCadetsAjax'])->name('cadets.suspended');
    Route::get('/cadets/swimming-pass-dates', [CadetManagementController::class, 'getSwimmingPassDates'])->name('cadets.swimming_dates');
    // === END NEW ROUTES ===
    
    Route::get('/cadets/{cadet}', [CadetManagementController::class, 'show'])->name('cadets.show');

    // Position Management
    Route::post('/cadets/positions', [CadetManagementController::class, 'updatePositions'])->name('cadets.positions.update');

    // Swimming Qualification
    Route::post('/cadets/swimming/mark-passed', [CadetManagementController::class, 'markSwimmingPassed'])->name('cadets.swimming.mark-passed');

    // Rank Up
    Route::post('/cadets/rank-up', [CadetManagementController::class, 'rankUp'])->name('cadets.rank-up');

    // Suspend Cadet
    Route::post('/cadets/{cadet}/suspend', [CadetManagementController::class, 'suspend'])->name('cadets.suspend');

    // Delete Cadet
    Route::delete('/cadets/{cadet}', [CadetManagementController::class, 'destroy'])->name('cadets.destroy');

    // Reactivate Cadet
    Route::post('/cadets/{cadet}/reactivate', [CadetManagementController::class, 'reactivate'])->name('cadets.reactivate');

    // Best Cadet and Best Academic Toggle
    Route::post('/cadets/{cadet}/toggle-best-cadet', [CadetManagementController::class, 'toggleBestCadet'])->name('cadets.toggle-best-cadet');
    Route::post('/cadets/{cadet}/toggle-best-academic', [CadetManagementController::class, 'toggleBestAcademic'])->name('cadets.toggle-best-academic');

    // Tauliah Settings
    Route::post('/cadets/tauliah-settings', [CadetManagementController::class, 'updateTauliahSettings'])->name('cadets.tauliah-settings');

    // ------------------------------------------------------------------------
    // Training Management
    // ------------------------------------------------------------------------
    
    Route::get('/training', [InstructorTrainingController::class, 'index'])->name('training');
    Route::post('/training', [InstructorTrainingController::class, 'store'])->name('training.store');
    Route::get('/training/{training}', [InstructorTrainingController::class, 'show'])->name('training.show');
    Route::put('/training/{training}', [InstructorTrainingController::class, 'update'])->name('training.update');
    Route::delete('/training/{training}', [InstructorTrainingController::class, 'destroy'])->name('training.destroy');
    Route::post('/training/{training}/end', [InstructorTrainingController::class, 'endTraining'])->name('training.end');
    Route::get('/training/{training}/qr-code', [InstructorTrainingController::class, 'generateQrCode'])->name('training.qr-code');
    Route::get('/training/{training}/cadets', [InstructorTrainingController::class, 'getCadetsForAttendance'])->name('training.cadets');
    
    // Attendance management
    Route::post('/training/{training}/attendance', [InstructorTrainingController::class, 'saveAttendance'])->name('training.attendance');
    Route::post('/training/{training}/attendance/qr', [InstructorTrainingController::class, 'recordQrAttendance'])->name('training.attendance.qr');
    Route::get('/attendance-list', [InstructorTrainingController::class, 'getAllAttendanceList'])->name('attendance.list.all');
    
    // AJAX endpoints for instructor attendance filters
    Route::get('/getYears', [InstructorTrainingController::class, 'getYears']);
    Route::get('/getMonths', [InstructorTrainingController::class, 'getMonths']);
    Route::get('/getCadetAttendanceList', [InstructorTrainingController::class, 'getCadetAttendanceList']);

    // ------------------------------------------------------------------------
    // Allowance Management
    // ------------------------------------------------------------------------
    
    Route::get('/allowance', [AllowanceController::class, 'index'])->name('allowance');
    Route::get('/allowance/training/{training}/details', [AllowanceController::class, 'getTrainingDetails'])->name('allowance.training.details');

    // ------------------------------------------------------------------------
    // Inventory Management
    // ------------------------------------------------------------------------
    
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

    // Issuance tracking AJAX
    Route::get('/inventory/issuance-tracking/ajax', [InstructorInventoryController::class, 'getIssuanceTrackingAjax'])->name('inventory.issuance-tracking.ajax');

    // Export routes
    Route::get('/inventory/export/uniforms', [InstructorInventoryController::class, 'exportUniformSizes'])->name('inventory.export.uniforms');
    Route::get('/inventory/export/loans', [InstructorInventoryController::class, 'exportEquipmentLoans'])->name('inventory.export.loans');
    Route::get('/inventory/export/uniform-summary', [InstructorInventoryController::class, 'exportUniformSizeSummary'])->name('inventory.export.uniform-summary');

    // ------------------------------------------------------------------------
    // Learning Hub Management
    // ------------------------------------------------------------------------
    
    Route::get('/learning_hub', [InstructorLearningHubController::class, 'index'])->name('learning_hub');
    Route::get('/learning-hub/filter', [InstructorLearningHubController::class, 'getFilteredMaterials'])->name('learning_hub.filter');
    
    // Learning Materials routes
    Route::post('/learning-materials', [InstructorLearningHubController::class, 'store'])->name('learning_materials.store');
    Route::get('/learning-materials/{material}/edit', [InstructorLearningHubController::class, 'edit'])->name('learning_materials.edit');
    Route::put('/learning-materials/{material}', [InstructorLearningHubController::class, 'update'])->name('learning_materials.update');
    Route::delete('/learning-materials/{material}', [InstructorLearningHubController::class, 'destroy'])->name('learning_materials.destroy');
    
    // Category routes
    Route::post('/categories', [InstructorLearningHubController::class, 'storeCategory'])->name('learning_material_categories.store');
    Route::delete('/categories/{category}', [InstructorLearningHubController::class, 'destroyCategory'])->name('learning_material_categories.destroy');
    
    // Quiz routes
    Route::post('/quiz', [InstructorLearningHubController::class, 'storeQuiz'])->name('quiz.store');
    Route::put('/quiz/{question}', [InstructorLearningHubController::class, 'updateQuiz'])->name('quiz.update');
    Route::delete('/quiz/{question}', [InstructorLearningHubController::class, 'destroyQuiz'])->name('quiz.destroy');
    Route::get('/quiz-questions', [InstructorLearningHubController::class, 'getQuizQuestions'])->name('quiz.questions');

    // ------------------------------------------------------------------------
    // Gallery Management
    // ------------------------------------------------------------------------

    Route::get('/gallery', [InstructorGalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery', [InstructorGalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{gallery}', [InstructorGalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [InstructorGalleryController::class, 'destroy'])->name('gallery.destroy');

    // Gallery category routes
    Route::post('/gallery-categories', [InstructorGalleryController::class, 'storeCategory'])->name('gallery_categories.store');
    Route::delete('/gallery-categories/{category}', [InstructorGalleryController::class, 'destroyCategory'])->name('gallery_categories.destroy');

    // ------------------------------------------------------------------------
    // Report Generation
    // ------------------------------------------------------------------------

    Route::get('/reports', [App\Http\Controllers\Instructor\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/training', [App\Http\Controllers\Instructor\ReportController::class, 'trainingReport'])->name('reports.training');
    Route::get('/reports/attendance', [App\Http\Controllers\Instructor\ReportController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('/reports/inventory', [App\Http\Controllers\Instructor\ReportController::class, 'inventoryReport'])->name('reports.inventory');
    Route::get('/reports/performance', [App\Http\Controllers\Instructor\ReportController::class, 'performanceReport'])->name('reports.performance');
    Route::get('/reports/financial', [App\Http\Controllers\Instructor\ReportController::class, 'financialReport'])->name('reports.financial');
    Route::get('/reports/analytics', [App\Http\Controllers\Instructor\ReportController::class, 'analytics'])->name('reports.analytics');

    // Export routes
    Route::get('/reports/training/export', [App\Http\Controllers\Instructor\ReportController::class, 'exportTrainingReport'])->name('reports.training.export');
    Route::get('/reports/attendance/export', [App\Http\Controllers\Instructor\ReportController::class, 'exportAttendanceReport'])->name('reports.attendance.export');
    Route::get('/reports/inventory/export', [App\Http\Controllers\Instructor\ReportController::class, 'exportInventoryReport'])->name('reports.inventory.export');
    Route::get('/reports/performance/export', [App\Http\Controllers\Instructor\ReportController::class, 'exportPerformanceReport'])->name('reports.performance.export');
    Route::get('/reports/financial/export', [App\Http\Controllers\Instructor\ReportController::class, 'exportFinancialReport'])->name('reports.financial.export');
});

// ============================================================================
// CADET ROUTES
// ============================================================================

Route::middleware(['auth', 'verified'])->prefix('cadet')->name('cadet.')->group(function () {
    
    // ------------------------------------------------------------------------
    // Cadet Dashboard
    // ------------------------------------------------------------------------
    
    Route::get('/dashboard', [CadetDashboardController::class, 'index'])->name('dashboard');
    Route::get('/cadet/{cadet}/details', [CadetDashboardController::class, 'getCadetDetails'])->name('cadet.details');

    // ------------------------------------------------------------------------
    // Training
    // ------------------------------------------------------------------------
    
    Route::get('/training', [CadetTrainingController::class, 'index'])->name('training');
    Route::get('/training/{training}', [CadetTrainingController::class, 'show'])
        ->whereNumber('training')
        ->name('training.show');

    // ------------------------------------------------------------------------
    // Allowance
    // ------------------------------------------------------------------------
    
    Route::get('/allowance', [\App\Http\Controllers\Cadet\AllowanceController::class, 'index'])->name('allowance');
    Route::get('/allowance/ajax', [\App\Http\Controllers\Cadet\AllowanceController::class, 'ajax'])->name('allowance.ajax');

    // ------------------------------------------------------------------------
    // Inventory
    // ------------------------------------------------------------------------
    
    Route::delete('/inventory/uniform-size/{cadetSize}', [CadetInventoryController::class, 'deleteUniformSize'])->name('inventory.uniform-size.delete');
    Route::post('/inventory/uniform-size', [CadetInventoryController::class, 'updateUniformSize'])->name('inventory.uniform-size.update');
    Route::patch('/inventory/uniform-size/{cadetSize}/toggle-issue', [CadetInventoryController::class, 'toggleIssueStatus'])->name('inventory.uniform-size.toggle-issue');
    Route::get('/inventory', [CadetInventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/profile', [CadetInventoryController::class, 'myProfile'])->name('inventory.profile');
    Route::get('/inventory/uniform-types/{uniformTypeId}/components', [CadetInventoryController::class, 'getComponentsByType'])->name('inventory.components-by-type');
    Route::post('/inventory/loan', [CadetInventoryController::class, 'createLoan'])->name('inventory.loan.create');
    Route::patch('/inventory/loan/{loan}/return', [CadetInventoryController::class, 'returnLoan'])->name('inventory.loan.return');

    // ------------------------------------------------------------------------
    // Learning Hub
    // ------------------------------------------------------------------------
    
    Route::get('/learning_hub', [CadetLearningHubController::class, 'index'])->name('learning_hub');
    Route::post('/learning/start', [CadetLearningHubController::class, 'startMaterial'])->name('learning.start');
    Route::post('/learning/complete', [CadetLearningHubController::class, 'completeMaterial'])->name('learning.complete');
    Route::get('/learning/progress', [CadetLearningHubController::class, 'getProgress'])->name('learning.progress');

    // ------------------------------------------------------------------------
    // Performance
    // ------------------------------------------------------------------------

    Route::get('/performance', [App\Http\Controllers\Cadet\PerformanceController::class, 'index'])->name('performance');
    Route::post('/performance/toggle-badge', [App\Http\Controllers\Cadet\PerformanceController::class, 'toggleBadgeDisplay'])->name('performance.toggle-badge');

    // ------------------------------------------------------------------------
    // Gallery
    // ------------------------------------------------------------------------
    
    Route::get('/gallery', [CadetGalleryController::class, 'index'])->name('gallery');
    Route::get('/gallery/category/{categoryId}', [CadetGalleryController::class, 'getByCategory'])->name('gallery.category');
    Route::get('/gallery/categories', [CadetGalleryController::class, 'getCategories'])->name('gallery.categories');

    // ------------------------------------------------------------------------
    // Attendance
    // ------------------------------------------------------------------------
    
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/mark', [AttendanceController::class, 'markPresent'])->name('attendance.mark');
    Route::post('/attendance/absence/{attendance}', [AttendanceController::class, 'submitAbsence'])->name('attendance.absence');
    Route::post('/attendance/verify-qr', [AttendanceController::class, 'verifyQR'])->name('attendance.verify-qr');
});

// ============================================================================
// ADMIN ROUTES
// ============================================================================

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted' || $user->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/user_management', [App\Http\Controllers\Admin\AdminController::class, 'userManagement'])->name('user_management');
    Route::get('/user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'getUser'])->name('user.show');
    Route::put('/user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('/user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('user.delete');
    Route::get('/data_management', [App\Http\Controllers\Admin\AdminController::class, 'dataManagement'])->name('data_management');
    Route::get('/data/{model}/{id}', [App\Http\Controllers\Admin\AdminController::class, 'getData'])->name('data.show');
    Route::put('/data/{model}/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateData'])->name('data.update');
    Route::delete('/data/{model}/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteData'])->name('data.delete');
    Route::get('/user_management/search-cadets', [App\Http\Controllers\Admin\AdminController::class, 'searchCadets'])->name('user_management.search_cadets');
    Route::get('/user_management/search-instructors', [App\Http\Controllers\Admin\AdminController::class, 'searchInstructors'])->name('user_management.search_instructors');
    Route::get('/data_management/search', [App\Http\Controllers\Admin\AdminController::class, 'searchData'])->name('data_management.search');
    
    // Access Management Routes
    Route::get('/access_management', [App\Http\Controllers\Admin\AdminController::class, 'accessManagement'])->name('access_management');
    Route::post('/access_management/transfer', [App\Http\Controllers\Admin\AdminController::class, 'transferAdmin'])->name('access_management.transfer');

    // Gamification Management Routes
    Route::get('/gamification_management', [App\Http\Controllers\Admin\AdminController::class, 'gamificationManagement'])->name('gamification_management');
    Route::post('/badges', [App\Http\Controllers\Admin\AdminController::class, 'storeBadge'])->name('badges.store');
    Route::get('/badges/{id}', [App\Http\Controllers\Admin\AdminController::class, 'getBadge'])->name('badges.show');
    Route::put('/badges/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateBadge'])->name('badges.update');
    Route::delete('/badges/{id}', [App\Http\Controllers\Admin\AdminController::class, 'deleteBadge'])->name('badges.delete');
});

// ============================================================================
// AUTH ROUTES
// ============================================================================

require __DIR__.'/auth.php';