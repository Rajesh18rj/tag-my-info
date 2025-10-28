<?php

use App\Http\Controllers\AllergyController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\HealthInsuranceController;
use App\Http\Controllers\InstructionsController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PetOwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileQrController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\QrBatchController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\VetDetailsController;
use App\Http\Controllers\VitalMedicalConditionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//----------Routes for Manage Profiles----------//
    // Show all profiles
        Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles.index');

    // Show form to create a new profile
        Route::get('/profiles/create', [ProfilesController::class, 'create'])->name('profiles.create');

    // Store new profile
        Route::post('/profiles', [ProfilesController::class, 'store'])->name('profiles.store');

    // Show a single profile
    //    Route::get('/profiles/{profile}', [ProfilesController::class, 'show'])->name('profiles.show');

    // Show form to edit a profile
        Route::get('/profiles/{profile}/edit', [ProfilesController::class, 'edit'])->name('profiles.edit');

    // Update a profile
        Route::put('/profiles/{profile}', [ProfilesController::class, 'update'])->name('profiles.update');
        Route::patch('/profiles/{profile}', [ProfilesController::class, 'update']); // optional for PATCH requests

    // Delete a profile
        Route::delete('/profiles/{profile}', [ProfilesController::class, 'destroy'])->name('profiles.destroy');

    // Toggle Bar
    Route::post('/profiles/{profile}/toggle-public', [ProfilesController::class, 'togglePublic'])
        ->name('profiles.toggle-public');

//----------Routes for Pop-up Modals----------//
    // EmergencyContact CRUD
    Route::resource('profiles.emergency-contacts', EmergencyContactController::class)->only(['store', 'update', 'destroy']);
    // Allergies CRUD
    Route::resource('profiles.allergies', AllergyController::class)->only(['store', 'update', 'destroy']);
    // Medication CRUD
    Route::resource('profiles.medications', MedicationController::class)->only(['store', 'update', 'destroy']);
    // Health Insurance CRUD
    Route::resource('profiles.health-insurances', HealthInsuranceController::class)->only(['store', 'update', 'destroy']);
    // Vital Medical Condition CRUD
    Route::resource('profiles.vital-medical-conditions', VitalMedicalConditionController::class)->only(['store', 'update', 'destroy']);
    // Pet Owner CRUD
    Route::resource('profiles.pet-owners', PetOwnerController::class)->only(['store', 'update', 'destroy']);
    // Vet Details CRUD
    Route::resource('profiles.vet-details', VetDetailsController::class)->only(['store', 'update', 'destroy']);
    // Instruction CRUD
    Route::resource('profiles.instructions', InstructionsController::class)->only(['store', 'update', 'destroy']);

//----------Routes for QR ----------//
    Route::get('/qr-generate', [QrCodeController::class, 'showGenerateForm'])->name('qr.showGenerateForm');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::get('/qr-list', [QrCodeController::class, 'index'])->name('qr.list');


//    Route::get('qr/download/{filename}', [QrCodeController::class, 'qrDownload'])->name('qr.qrDownload');


//--------- Routes for Generate QR with Batch wise -----------//
    Route::get('/qr-batches', [QrBatchController::class, 'index'])->name('qr.qr-batches.index');
    Route::post('/qr-batches', [QrBatchController::class, 'store'])->name('qr.qr-batches.store');
    Route::get('/qr-batches/{batch}/download', [QrBatchController::class, 'download'])->name('qr.qr-batches.download');
    Route::post('/qr-batches/{batch}/status', [QrBatchController::class, 'updateStatus'])->name('qr-batches.update-status');


    //Route::get('/qr-list', [QrCodeController::class, 'list'])->name('qr.list');
    Route::get('/qr-form', [QrCodeController::class, 'showForm'])->name('qr.form');
    Route::post('/qr-form', [QrCodeController::class, 'storeForm'])->name('qr.store');

    // QR Download
    Route::get('/qr/{id}/download', [QrCodeController::class, 'download'])->name('qr.download');

    Route::get('/profiles/{profile}/link-qr', [ProfileQrController::class, 'create'])->name('profiles.link-qr');
    Route::post('/profiles/{profile}/link-qr', [ProfileQrController::class, 'store'])->name('profiles.link-qr.store');

    // AJAX route for QR code filtering with optional pagination
    Route::get('/qr-list/filter', [QrCodeController::class, 'filter'])->name('qr.list.filter');
});

//Route::get('/qr-details/{id}', [QrCodeController::class, 'showDetails'])->name('qr.details');

// Main route using UID
Route::get('/view/{uid}', [QrCodeController::class, 'showDetails'])
    ->name('qr.details');

// Redirect old ID route to UID

Route::get('/qr-details/{id}', function ($id) {
    $qr = QrCode::findOrFail($id);
    return redirect('/view/' . $qr->uid);
});


require __DIR__.'/auth.php';
