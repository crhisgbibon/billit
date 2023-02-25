<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerLog;
use App\Http\Controllers\ControllerStats;

Route::get('/', function(){
  return redirect('/log');
})->middleware(['auth', 'verified'])->name('Home');

Route::controller(ControllerLog::class)->group(function () {
  Route::get('/log', 'index')->middleware(['auth', 'verified'])->name('Log');
  Route::post('/log/GetDates', 'GetDates')->middleware(['auth', 'verified'])->name('GetDates');
  Route::post('/log/ToggleSession', 'ToggleSession')->middleware(['auth', 'verified'])->name('ToggleSession');
  Route::post('/log/NewItem', 'NewItem')->middleware(['auth', 'verified'])->name('NewItem');
  Route::post('/log/CloseItem', 'CloseItem')->middleware(['auth', 'verified'])->name('CloseItem');
  Route::post('/log/RestartItem', 'RestartItem')->middleware(['auth', 'verified'])->name('RestartItem');
  Route::post('/log/DeleteItem', 'DeleteItem')->middleware(['auth', 'verified'])->name('DeleteItem');
  Route::post('/log/UpdateItem', 'UpdateItem')->middleware(['auth', 'verified'])->name('UpdateItem');
  Route::post('/log/UpdateSession', 'UpdateSession')->middleware(['auth', 'verified'])->name('UpdateSession');
});

Route::controller(ControllerStats::class)->group(function () {
  Route::get('/stats', 'index')->middleware(['auth', 'verified'])->name('Stats');
  Route::post('/stats/GetDates/colleague', 'GetColleague')->middleware(['auth', 'verified'])->name('GetDatesColleague');
  Route::post('/stats/GetDates/reference', 'GetReference')->middleware(['auth', 'verified'])->name('GetDatesReference');
  Route::post('/stats/GetDates/summary', 'GetSummary')->middleware(['auth', 'verified'])->name('GetDatesSummary');
  Route::post('/stats/GetDates/session', 'GetSession')->middleware(['auth', 'verified'])->name('GetDatesSession');
  Route::post('/stats/GetDates/task', 'GetTask')->middleware(['auth', 'verified'])->name('GetDatesTask');
  Route::post('/stats/GetDates/weekday', 'GetWeekday')->middleware(['auth', 'verified'])->name('GetDatesWeekday');
  Route::post('/stats/GetDates/Weekday/Chart', 'ChartWeekday')->middleware(['auth', 'verified'])->name('GetChartWeekday');
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';