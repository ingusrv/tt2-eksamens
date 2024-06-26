<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [BoardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/board', [BoardController::class, 'store'])->name("board.store");
    Route::get('/board/{id}', [BoardController::class, 'show'])->name("board.show");
    Route::delete('/board/{id}', [BoardController::class, 'destroy'])->name("board.destroy");

    Route::get('/board/{id}/edit', [BoardController::class, 'edit'])->name("board.edit");
    Route::patch('/board/{id}/edit', [BoardController::class, 'update'])->name("board.update");

    Route::post('/board/{id}/column', [ColumnController::class, 'store'])->name("column.store");
    Route::post('/board/{id}/column/{cid}', [CardController::class, 'store'])->name("card.store");
});

require __DIR__ . '/auth.php';
