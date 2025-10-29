<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\CaptainController;
use App\Http\Controllers\TanodController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\UrgentRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Verification Pending Page
Route::get('/verification-pending', function () {
    return view('verification-pending');
})->middleware('auth')->name('verification.pending');

// Dashboard - Role-based routing
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isCitizen()) {
        if (!$user->isVerified()) {
            return redirect()->route('verification.pending');
        }
        return redirect()->route('citizen.dashboard');
    } elseif ($user->isSecretary()) {
        return redirect()->route('secretary.dashboard');
    } elseif ($user->isCaptain()) {
        return redirect()->route('captain.dashboard');
    } elseif ($user->isTanod()) {
        return redirect()->route('tanod.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Citizen Routes
Route::middleware(['auth', 'role:citizen', 'verified.citizen'])->prefix('citizen')->name('citizen.')->group(function () {
    Route::get('/dashboard', [CitizenController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints', [CitizenController::class, 'complaints'])->name('complaints');
    Route::get('/qr-code', [CitizenController::class, 'qrCode'])->name('qr-code');
});

// Secretary Routes
Route::middleware(['auth', 'role:secretary'])->prefix('secretary')->name('secretary.')->group(function () {
    Route::get('/dashboard', [SecretaryController::class, 'dashboard'])->name('dashboard');
    
    // User Verification
    Route::get('/pending-users', [SecretaryController::class, 'pendingUsers'])->name('pending-users');
    Route::post('/users/{user}/verify', [SecretaryController::class, 'verifyUser'])->name('users.verify');
    Route::post('/users/{user}/reject', [SecretaryController::class, 'rejectUser'])->name('users.reject');
    
    // Complaint Validation
    Route::get('/pending-complaints', [SecretaryController::class, 'pendingComplaints'])->name('pending-complaints');
    Route::post('/complaints/{complaint}/validate', [SecretaryController::class, 'validateComplaint'])->name('complaints.validate');
    Route::post('/complaints/{complaint}/reject', [SecretaryController::class, 'rejectComplaint'])->name('complaints.reject');
    
    // Citizen Management (CRUD)
    Route::get('/citizens', [SecretaryController::class, 'manageCitizens'])->name('citizens.index');
    Route::get('/citizens/create', [SecretaryController::class, 'createCitizen'])->name('citizens.create');
    Route::post('/citizens', [SecretaryController::class, 'storeCitizen'])->name('citizens.store');
    Route::get('/citizens/{user}/edit', [SecretaryController::class, 'editCitizen'])->name('citizens.edit');
    Route::put('/citizens/{user}', [SecretaryController::class, 'updateCitizen'])->name('citizens.update');
    Route::delete('/citizens/{user}', [SecretaryController::class, 'deleteCitizen'])->name('citizens.destroy');
    Route::get('/citizens/{user}', [SecretaryController::class, 'showCitizen'])->name('citizens.show');
});

// Captain Routes
Route::middleware(['auth', 'role:captain'])->prefix('captain')->name('captain.')->group(function () {
    Route::get('/dashboard', [CaptainController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints', [CaptainController::class, 'complaints'])->name('complaints');
    Route::get('/complaints/{complaint}', [CaptainController::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/resolve', [CaptainController::class, 'resolve'])->name('complaints.resolve');
    Route::post('/complaints/{complaint}/in-progress', [CaptainController::class, 'markInProgress'])->name('complaints.in-progress');
    Route::get('/analytics', [CaptainController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [CaptainController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [CaptainController::class, 'exportReport'])->name('reports.export');
    
    // Complaint Categories CRUD
    Route::get('/categories', [CaptainController::class, 'listCategories'])->name('categories.index');
    Route::get('/categories/create', [CaptainController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [CaptainController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{complaint_category}/edit', [CaptainController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{complaint_category}', [CaptainController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{complaint_category}', [CaptainController::class, 'destroyCategory'])->name('categories.destroy');
});

// Tanod Routes
Route::middleware(['auth', 'role:tanod', 'verified.citizen'])->prefix('tanod')->name('tanod.')->group(function () {
    Route::get('/dashboard', [TanodController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending', [TanodController::class, 'pending'])->name('pending');
    Route::get('/assigned', [TanodController::class, 'assigned'])->name('assigned');
    Route::get('/resolved', [TanodController::class, 'resolved'])->name('resolved');
    Route::get('/{urgent_request}', [TanodController::class, 'show'])->name('show');
    Route::post('/{urgent_request}/assign', [TanodController::class, 'assign'])->name('assign');
    Route::post('/{urgent_request}/update-status', [TanodController::class, 'updateStatus'])->name('update-status');
});

// Complaint Routes (Accessible by verified citizens)
Route::middleware(['auth', 'role:citizen', 'verified.citizen'])->group(function () {
    Route::resource('complaints', ComplaintController::class);
});

// Urgent Request Routes (Accessible by verified citizens)
Route::middleware(['auth', 'role:citizen', 'verified.citizen'])->group(function () {
    Route::resource('urgent-requests', UrgentRequestController::class);
    Route::post('/urgent-requests/{urgent_request}/cancel', [UrgentRequestController::class, 'cancel'])->name('urgent-requests.cancel');
    Route::get('/urgent-requests/{urgent_request}/track', [UrgentRequestController::class, 'track'])->name('urgent-requests.track');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
