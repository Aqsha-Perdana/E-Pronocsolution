<?php

use App\Http\Controllers\DepanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\FundRealizationController;
use App\Livewire\ProposalWizard;
use App\Livewire\FundRealizationReport;
use App\Livewire\FundRealizationReportEdit;
use App\Livewire\FundRealizationReportShow; // Make sure to import this
use App\Livewire\Profile;
use App\Http\Controllers\ProposalSelectionController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ProposalReviewController;
use App\Http\Middleware\AdminMiddleware;


/*s 
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

// // =================================================================
// // 2. PROTECTED ROUTES (REQUIRES LOGIN)
// // =================================================================

// Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ---
   Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('peneliti');
    // --- PROFILE ---
    Route::get('/profilepeneliti', Profile::class)->name('profile')->middleware('peneliti');

    // --- PROPOSAL MANAGEMENT ---
    Route::get('/proposalutama', [ProposalController::class, 'index'])->name('mainproposalutama')->middleware('peneliti');
    Route::get('/proposals/create', ProposalWizard::class)->name('proposals.create')->middleware('peneliti');;
    Route::get('/proposals/{id}', [ProposalController::class, 'show'])->name('proposals.show')->middleware('peneliti');;
    Route::get('/proposal/{id}/download', [ProposalController::class, 'download'])->name('proposal.download')->middleware('peneliti');;

    // --- PROGRESS REPORT ---
    Route::prefix('progress')->name('progress.')->group(function () {
        Route::get('/', [DashboardController::class, 'progress'])->name('index')->middleware('peneliti');;
        Route::get('/{id}/edit', [DashboardController::class, 'editProgress'])->name('edit')->middleware('peneliti');;
        Route::put('/{id}', [DashboardController::class, 'updateProgress'])->name('update')->middleware('peneliti');;
        Route::delete('/{id}', [DashboardController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/view', [DashboardController::class, 'showPdf'])->name('view');
        Route::get('/{id}/download', [DashboardController::class, 'downloadPdf'])->name('download');
    });

    // --- FINAL REPORT ---
    Route::prefix('final')->name('final.')->group(function () {
        Route::get('/', [DashboardController::class, 'final'])->name('index')->middleware('peneliti');; // Changed from name('final') to name('final.index') for consistency, but you can keep 'final'
        Route::post('/', [DashboardController::class, 'storeFinal'])->name('store');
        Route::get('/{id}/edit', [DashboardController::class, 'editFinal'])->name('edit');
        Route::delete('/{id}', [DashboardController::class, 'destroyFinal'])->name('destroy');
        Route::get('/download/{id}', [DashboardController::class, 'downloadFinal'])->name('download');
        Route::get('/view/{id}', [DashboardController::class, 'showFinal'])->name('view')->middleware('peneliti');;
    });
    // Alias for 'final' route to match your controller return if you use route('final')
    Route::get('/final-list', [DashboardController::class, 'final'])->name('final')->middleware('peneliti'); 


    // --- FUND REALIZATION REPORT ---
    Route::get('/fund-realization-report', FundRealizationReport::class)->name('report.fund');
    Route::get('/fund-realization/{id}/edit', FundRealizationReportEdit::class)->name('report.fund.edit');
    Route::get('/fund-realization-report/{id}/view', FundRealizationReportShow::class)->name('report.fund.show')->middleware('peneliti');;
    Route::get('/fund-realization/{id}/download-pdf', [FundRealizationController::class, 'downloadPdf'])->name('report.fund.download');

///////// NAVIGASI DI HALAMAN ADMIN //////////////
Route::get('/dashboard-admin', function () {
     $user = Auth::user();
    return view('dashboard-admin', compact('user'));
})->name('dashboard-admin')
->middleware('admin');


Route::post('/skills/update', [SkillController::class, 'updateSkills'])->name('skills.updateSkills');
Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');



Route::get('proposalsel/{page?}', [ProposalSelectionController::class, 'show'])
     ->name('proposal')
     ->middleware('admin');

Route::get('/information-center', function () {
    return view('information');
})->name('information')
->middleware('admin');


Route::get('/profile-admin', [ProfileController::class, 'profile'])->name('profileadmin')->middleware('admin');

Route::put('/profile/update', [ProfileController::class, 'updateAdmin'])->name('profile.update')->middleware('admin');

Route::post('/profile/update', [ProfileController::class, 'updateAdmin'])->name('profile.update')->middleware('admin');



Route::get('/logout', function () {
    return view('logout');
})->name('logout');
Route::get('/editprofile', function () {
    return view('editprofile');
})->name('editprofile')->middleware('admin');


///////// NAVIGASI PROPOSAL SELECTION //////////////

Route::get('proposalsel/{page?}', [ProposalSelectionController::class, 'show'])
     ->name('proposal')
     ->middleware('admin');

Route::prefix('proposalsel')->name('proposalsel.')->group(function () {

    Route::get('/list', function () {
        return view('proposalsel.list', ['page' => 'list']);
    })->name('list');

    Route::get('/review', function () {
        return view('proposalsel.review', ['page' => 'review']);
    })->name('review');

    Route::get('/grading', function () {
        return view('proposalsel.done', ['page' => 'done']);
    })->name('review');

    Route::get('/progress', function () {
        return view('proposalsel.progress', ['page' => 'progress']);
    })->name('progress');

    Route::get('/done', function () {
        return view('proposalsel.done', ['page' => 'done']);
    })->name('done');

    Route::get('/final', function () {
        return view('proposalsel.final', ['page' => 'final']);
    })->name('final');
});

// Accept
Route::post('/proposalsel/review/{proposal}/accept', [ProposalController::class, 'accept'])
    ->name('proposal.accept');

// Reject
Route::post('/proposalsel/review/{proposal}/reject', [ProposalController::class, 'reject'])
    ->name('proposal.reject');

Route::get('/proposals/done', [ProposalController::class, 'done'])->name('proposalsel.done');
Route::get('/proposals/{id}/graded', [ProposalController::class, 'graded'])->name('proposalsel.graded');
Route::post('/admin/proposals/{id}/submit-review', [ProposalController::class, 'submitReview'])->name('admin.proposals.submit-review');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get(
        '/review/progress-review/{proposal}',
        [ProposalReviewController::class, 'create']
    )->name('proposalsel.progress_review');

    Route::post('/progress-report/{id}/{action}', 
    [ProposalReviewController::class, 'complete']
)->name('progress.complete');

Route::patch('/progress-report/{id}/complete', 
    [ProposalReviewController::class, 'complete'])
    ->name('progress.complete');
});

Route::get('/proposalsel/final-review/{id}', [ProposalReviewController::class, 'finalReview'])
    ->name('proposalsel.finalreview');

Route::post(
    'proposalsel/final-review/{finalReport}/finish',
    [ProposalReviewController::class, 'finishFinalReport']
)->name('proposalsel.final.finish');


