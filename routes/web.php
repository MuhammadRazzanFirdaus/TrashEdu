<?php

use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RewardRedemptionController;
use App\Http\Controllers\StaffRewardRedemptionController;
use App\Http\Controllers\UserWasteController;
use App\Http\Controllers\WasteSubmissionController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/signup', function () {
    return view('signup');
})->name('signup')->middleware(('isGuest'));

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware(('isGuest'));

Route::get('/exchange', function () {
    return view('exchange');
})->name('exchange')->middleware(('isGuest'));

Route::post('/signup', [UserController::class, 'store'])->name('signup.store')->middleware(('isGuest'));
Route::post('/login', [UserController::class, 'login'])->name('login.auth')->middleware(('isGuest'));
Route::get('/logout', [UserController::class, 'logout'])->name('logout');



Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    // Progress Routes
    Route::prefix('/progress')->name('progress.')->group(function () {
        Route::get('/', [UserProgressController::class, 'index'])->name('index');
        Route::get('/create', [UserProgressController::class, 'create'])->name('create');
        Route::post('/', [UserProgressController::class, 'store'])->name('store');
        Route::get('/{id}', [UserProgressController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserProgressController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserProgressController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserProgressController::class, 'destroy'])->name('destroy');

        // Additional routes
        Route::get('/user/{userId}/history', [UserProgressController::class, 'userHistory'])->name('user.history');
        Route::get('/quiz/{quizId}/leaderboard', [UserProgressController::class, 'quizLeaderboard'])->name('quiz.leaderboard');
        Route::get('/statistics', [UserProgressController::class, 'statistics'])->name('statistics');
    });

    Route::prefix('articles')->name('articles.')->group(function () {
        // Route untuk CRUD utama
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('/create', [ArticleController::class, 'create'])->name('create');
        Route::post('/', [ArticleController::class, 'store'])->name('store');
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}', [ArticleController::class, 'update'])->name('update');
        Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy');
        Route::get('/export', [ArticleController::class, 'exportExcel'])->name('export');
        Route::get('/export-pdf', [ArticleController::class, 'exportPDF'])->name('export.pdf');
        // Route untuk trash management
        Route::get('/trash/list', [ArticleController::class, 'trash'])->name('trash');
        Route::post('/trash/{id}/restore', [ArticleController::class, 'restore'])->name('restore');
        Route::delete('/trash/{id}/force-delete', [ArticleController::class, 'forceDelete'])->name('force-delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'storeStaff'])->name('storeStaff');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/export', [UserController::class, 'exportExcel'])->name('export');
        Route::get('/export-pdf', [UserController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/trash/list', [UserController::class, 'trash'])->name('trash');
        Route::post('/trash/{id}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/trash/{id}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
    });


    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/create', [QuizController::class, 'create'])->name('create');
        Route::post('/store', [QuizController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [QuizController::class, 'edit'])->name('edit');
        Route::put('/{id}', [QuizController::class, 'update'])->name('update');
        Route::delete('/{id}', [QuizController::class, 'destroy'])->name('destroy');
        Route::get('/export', [QuizController::class, 'exportExcel'])->name('export');
        Route::get('/export-pdf', [ArticleController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/export-pdf', [QuizController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/trash/list', [QuizController::class, 'trash'])->name('trash');
        Route::post('/trash/{id}/restore', [QuizController::class, 'restore'])->name('restore');
        Route::delete('/trash/{id}/force-delete', [QuizController::class, 'forceDelete'])->name('force-delete');
    });
});

Route::middleware('isStaff')->prefix('/staff')->name('staff.')->group(function () {
    Route::get('/index', function () {
        return view('staff.index');
    })->name('index');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/quizzes', [UserQuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{id}/start', [UserQuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quizzes/{id}', [UserQuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{id}/submit', [UserQuizController::class, 'submitAnswer'])->name('quizzes.submit');
    Route::get('/quizzes/{id}/result', [UserQuizController::class, 'result'])->name('quizzes.result');
    Route::get('/quizzes/{id}/leaderboard', [UserQuizController::class, 'leaderboard'])->name('quizzes.leaderboard');
    Route::get('/my-results', [UserQuizController::class, 'myResults'])->name('quizzes.my-results');

    Route::get('/articles', [ArticleController::class, 'showForUser'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class, 'showArticle'])->name('articles.show');

    Route::prefix('waste')->name('waste.')->group(function () {
        Route::get('/create', [UserWasteController::class, 'create'])->name('submit');
        Route::post('/store', [UserWasteController::class, 'store'])->name('store');
        Route::get('/history', [UserWasteController::class, 'history'])->name('history');
    });

    Route::get('/rewards/redeem', [RewardRedemptionController::class, 'create'])->name('rewards.redeem');
    Route::post('/rewards/redeem', [RewardRedemptionController::class, 'store'])->name('rewards.store');

    // Riwayat penukaran user
    Route::get('/rewards/history', [RewardRedemptionController::class, 'history'])->name('rewards.history');
});


Route::prefix('petugas')->middleware('isStaff')->name('staff.')->group(function () {
    Route::get('/rewards/chart/line', [ChartController::class, 'rewardLineChart'])->name('rewards.chart.line');
    Route::get('/rewards/chart/pie', [ChartController::class, 'trashPieChart'])->name('rewards.chart.pie');
    Route::prefix('rewards')->name('rewards.')->group(function () {
        Route::get('/', [RewardController::class, 'index'])->name('index');
        Route::post('/store', [RewardController::class, 'store'])->name('store');
        Route::get('/create', [RewardController::class, 'create'])->name('create');
        Route::get('/edit', [RewardController::class, 'edit'])->name('edit');
        Route::put('/update', [RewardController::class, 'update'])->name('update');
        Route::get('rewards/trash', [RewardController::class, 'trash'])->name('trash');
        Route::delete('/delete/{id}', [RewardController::class, 'destroy'])->name('destroy');
        Route::get('rewards/{id}/restore', [RewardController::class, 'restore'])->name('restore');
        Route::delete('rewards/{id}/force-delete', [RewardController::class, 'forceDelete'])->name('forceDelete');
        Route::get('rewards/export/excel', [RewardController::class, 'exportExcel'])->name('exportExcel');
        Route::get('rewards/export/pdf', [RewardController::class, 'exportPDF'])->name('exportPDF');
    });

    Route::prefix('submission')->name('submissions.')->group(function () {
        Route::get('/', [WasteSubmissionController::class, 'index'])->name('index');
        Route::put('/{id}', [WasteSubmissionController::class, 'updateStatus'])->name('updateStatus');
    });


    Route::prefix('waste')->name('waste.')->group(function () {
        Route::get('/', [WasteSubmissionController::class, 'index'])->name('index');
        Route::post('/{$id}/verify', [WasteSubmissionController::class, 'verify'])->name('verify');
    });

    Route::get('/redemptions', [StaffRewardRedemptionController::class, 'index'])->name('redemptions.index');

    // Approve penukaran
    Route::post('/redemptions/{id}/approve', [StaffRewardRedemptionController::class, 'approve'])->name('redemptions.approve');

    // Reject penukaran
    Route::post('/redemptions/{id}/reject', [StaffRewardRedemptionController::class, 'reject'])->name('redemptions.reject');
});
