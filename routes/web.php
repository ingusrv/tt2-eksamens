<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBoardController;
use App\Http\Controllers\SharedBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("index");

Route::get("/locale/{locale}", [LocalizationController::class, "set"])->name("locale.set");

Route::get("/public/board/{id}", [PublicBoardController::class, "show"])->name("publicBoard.show");

Route::get('/dashboard', [BoardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/panelOrder', [ProfileController::class, 'panelOrder'])->name('profile.panelOrder');

    Route::get('/admin/board/{id}', [AdminController::class, 'showBoard'])->name("adminBoard.show");
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('adminUser.destroy');

    Route::post('/board', [BoardController::class, 'store'])->name("board.store");
    Route::get('/board/{id}', [BoardController::class, 'show'])->name("board.show");
    Route::delete('/board/{id}', [BoardController::class, 'destroy'])->name("board.destroy");

    Route::get('/board/{id}/edit', [BoardController::class, 'edit'])->name("board.edit");
    Route::patch('/board/{id}/edit', [BoardController::class, 'update'])->name("board.update");

    Route::post('/board/{id}/share', [SharedBoardController::class, 'store'])->name("sharedboard.store");
    Route::delete('/board/{id}/share/{userId}', [SharedBoardController::class, 'destroy'])->name("sharedboard.destroy");

    Route::post('/board/{id}/column', [ColumnController::class, 'store'])->name("column.store");
    Route::delete('/board/{id}/column/{columnId}', [ColumnController::class, 'destroy'])->name("column.destroy");
    Route::patch('/board/{id}/column/{columnId}/swap/{targetColumnId}', [ColumnController::class, 'swap'])->name("column.swap");

    Route::post('/board/{id}/column/{columnId}', [CardController::class, 'store'])->name("card.store");
    Route::delete('/board/{id}/column/{columnId}/card/{cardId}', [CardController::class, 'destroy'])->name("card.destroy");
    Route::patch('/board/{id}/column/{columnId}/card/{cardId}/swap/{targetCardId}', [CardController::class, 'swap'])->name("card.swap");
    Route::patch('/board/{id}/column/{columnId}/card/{cardId}/move', [CardController::class, 'move'])->name("card.move");
});

require __DIR__ . '/auth.php';
