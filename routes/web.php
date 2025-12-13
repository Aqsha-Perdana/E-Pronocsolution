<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\FundRealizationController;
use App\Http\Controllers\DepanController;
use App\Livewire\ProposalWizard;
use App\Livewire\FundRealizationReport;
use App\Livewire\FundRealizationReportEdit;
use App\Livewire\FundRealizationReportShow; // Make sure to import this
use App\Livewire\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =================================================================
// 1. AUTHENTICATION ROUTES (GUEST)
// =================================================================

// Admin Auth
Route::get('/admin', [LoginController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('login.admin.submit');
Route::get('/admin/logout', [LoginController::class, 'logout']);

// Researcher Auth
Route::get('/researcher/login', [LoginController::class, 'showResearcherLogin'])->name('researcher.login');
Route::post('/researcher/login', [LoginController::class, 'loginResearcher'])->name('researcher.login.post');
Route::get('/researcher/register', [LoginController::class, 'register'])->name('researcher.register');
Route::post('/researcher/create', [LoginController::class, 'create'])->name('researcher.create');

// General Logout
Route::get("/logout", function(){
    return view("logout"); // Ensure you have a 'logout.blade.php' view
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//NAVIGASI DI LANDING PAGE//
Route::get('/', [DepanController::class,'index']);
Route::get('/pusatinformasi', [DepanController::class,'pusatinformasi']);
Route::get('/proyek', [DepanController::class,'proyek']);
Route::get('/tentang', [DepanController::class,'tentang']);

// =================================================================
// 2. PROTECTED ROUTES (REQUIRES LOGIN)
// =================================================================

Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- PROFILE ---
    Route::get('/profile', Profile::class)->name('profile');

    // --- PROPOSAL MANAGEMENT ---
    Route::get('/proposalutama', [ProposalController::class, 'index'])->name('mainproposalutama');
    Route::get('/proposals/create', ProposalWizard::class)->name('proposals.create');
    Route::get('/proposals/{id}', [ProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposal/{id}/download', [ProposalController::class, 'download'])->name('proposal.download');

    // --- PROGRESS REPORT ---
    Route::prefix('progress')->name('progress.')->group(function () {
        Route::get('/', [DashboardController::class, 'progress'])->name('index');
        Route::get('/{id}/edit', [DashboardController::class, 'editProgress'])->name('edit');
        Route::put('/{id}', [DashboardController::class, 'updateProgress'])->name('update');
        Route::delete('/{id}', [DashboardController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/view', [DashboardController::class, 'showPdf'])->name('view');
        Route::get('/{id}/download', [DashboardController::class, 'downloadPdf'])->name('download');
    });

    // --- FINAL REPORT ---
    Route::prefix('final')->name('final.')->group(function () {
        Route::get('/', [DashboardController::class, 'final'])->name('index'); // Changed from name('final') to name('final.index') for consistency, but you can keep 'final'
        Route::post('/', [DashboardController::class, 'storeFinal'])->name('store');
        Route::get('/{id}/edit', [DashboardController::class, 'editFinal'])->name('edit');
        Route::delete('/{id}', [DashboardController::class, 'destroyFinal'])->name('destroy');
        Route::get('/download/{id}', [DashboardController::class, 'downloadFinal'])->name('download');
        Route::get('/view/{id}', [DashboardController::class, 'showFinal'])->name('view');
    });
    // Alias for 'final' route to match your controller return if you use route('final')
    Route::get('/final-list', [DashboardController::class, 'final'])->name('final'); 


    // --- FUND REALIZATION REPORT ---
    Route::get('/fund-realization-report', FundRealizationReport::class)->name('report.fund');
    Route::get('/fund-realization/{id}/edit', FundRealizationReportEdit::class)->name('report.fund.edit');
    Route::get('/fund-realization-report/{id}/view', FundRealizationReportShow::class)->name('report.fund.show');
    Route::get('/fund-realization/{id}/download-pdf', [FundRealizationController::class, 'downloadPdf'])->name('report.fund.download');

});