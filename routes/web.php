<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerBillitLog;
use App\Http\Controllers\ControllerBillitStat;

Route::get('/', function(){
  return redirect('/log');
})->middleware(['auth', 'verified'])->name('billit');

Route::controller(ControllerBillitLog::class)->group(function () {
  Route::get('/log', 'index')->middleware(['auth', 'verified'])->name('billitLog');
  Route::post('/log/GetDates', 'GetDates')->middleware(['auth', 'verified'])->name('GetDates');
  Route::post('/log/ToggleSession', 'ToggleSession')->middleware(['auth', 'verified'])->name('ToggleSession');
  Route::post('/log/NewItem', 'NewItem')->middleware(['auth', 'verified'])->name('NewItem');
  Route::post('/log/CloseItem', 'CloseItem')->middleware(['auth', 'verified'])->name('CloseItem');
  Route::post('/log/RestartItem', 'RestartItem')->middleware(['auth', 'verified'])->name('RestartItem');
  Route::post('/log/DeleteItem', 'DeleteItem')->middleware(['auth', 'verified'])->name('DeleteItem');
  Route::post('/log/UpdateItem', 'UpdateItem')->middleware(['auth', 'verified'])->name('UpdateItem');
  Route::post('/log/UpdateSession', 'UpdateSession')->middleware(['auth', 'verified'])->name('UpdateSession');
});

Route::controller(ControllerBillitStat::class)->group(function () {
  Route::get('/stats', 'index')->middleware(['auth', 'verified'])->name('billitStats');
  Route::post('/stats/GetDates/Summary', 'GetSummary')->middleware(['auth', 'verified'])->name('GetDatesSummary');
  Route::post('/stats/GetDates/Weekday', 'GetWeekday')->middleware(['auth', 'verified'])->name('GetDatesWeekday');
  Route::post('/stats/GetDates/Weekday/Chart', 'ChartWeekday')->middleware(['auth', 'verified'])->name('GetChartWeekday');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';