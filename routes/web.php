<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminOtherServiceController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminQuotationController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminSettingController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/services', [PublicController::class, 'services'])->name('public.services.index');
Route::get('/services/{slug}', [PublicController::class, 'serviceDetail'])->name('public.services.detail');
Route::get('/projects', [PublicController::class, 'projects'])->name('public.projects.index');
Route::get('/projects/{slug}', [PublicController::class, 'projectDetail'])->name('public.projects.detail');
Route::get('/clients', [PublicController::class, 'clients'])->name('public.clients');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::post('/contact/submit', [ContactFormController::class, 'store'])->name('public.contact.submit');
Route::get('/request-quotation', [QuotationController::class, 'index'])->name('public.quotation');
Route::post('/request-quotation/submit', [QuotationController::class, 'store'])->name('public.quotation.submit');

// --- Auth Routes (Breeze) ---
Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Admin CRUD Panel Routes ---
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Single Unified Home Editor Route
    Route::get('home-editor', [AdminHomeController::class, 'index'])->name('home-editor');

    Route::resource('services', AdminServiceController::class);
    Route::resource('other-services', AdminOtherServiceController::class);
    Route::delete('projects/gallery/{id}', [AdminProjectController::class, 'deleteGalleryImage'])->name('projects.gallery.destroy');
    Route::resource('projects', AdminProjectController::class);
    Route::resource('clients', AdminClientController::class);
    
    // Company Statistics Settings
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Quotations (View, update status, delete)
    Route::get('quotations', [AdminQuotationController::class, 'index'])->name('quotations.index');
    Route::get('quotations/{id}', [AdminQuotationController::class, 'show'])->name('quotations.show');
    Route::patch('quotations/{id}/status', [AdminQuotationController::class, 'updateStatus'])->name('quotations.update-status');
    Route::delete('quotations/{id}', [AdminQuotationController::class, 'destroy'])->name('quotations.destroy');
    
    // Contacts (View, mark as read, delete)
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});

require __DIR__.'/auth.php';
