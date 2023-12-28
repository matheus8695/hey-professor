<?php

use App\Http\Controllers\{DashboardController, ProfileController, Question, QuestionController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route("dashboard");
    }
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    #region Question Routes
    Route::get('/question', [QuestionController::class, 'index'])->name('question.index');
    Route::post("/question/store", [QuestionController::class, "store"])->name("question.store");
    Route::post('/question/like/{question}', Question\LikeController::class)->name('question.like');
    Route::post('/question/unlike/{question}', Question\UnlikeController::class)->name('question.unlike');
    Route::put('/question/publish/{question}', Question\PublishController::class)->name('question.publish');
    #endregion

    #region Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    #endregion
});

require __DIR__ . '/auth.php';
