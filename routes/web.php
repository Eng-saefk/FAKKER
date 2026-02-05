<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController; // استدعاء واحد فقط هنا
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// صفحة التحديات (المباريات)
Route::get('/challenges', [GameController::class, 'index'])->name('challenges');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::post('/predict', [GameController::class, 'storePrediction'])->name('predict');
Route::get('/my-predictions', [GameController::class, 'myPredictions'])->name('my.predictions');
Route::get('/leaderboard', [GameController::class, 'leaderboard']);
Route::post('/settle-game', [GameController::class, 'settleGame'])->name('settle.game');
Route::get('/admin/create-game', [GameController::class, 'createGame']);
Route::post('/admin/store-game', [GameController::class, 'storeGame']);
// رابط عرض المتجر
Route::get('/shop', [GameController::class, 'shop']);

// رابط معالجة الشراء
Route::post('/buy-product/{id}', [GameController::class, 'buyProduct']);