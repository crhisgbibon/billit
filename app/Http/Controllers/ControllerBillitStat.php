<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ModelBillit;

class ControllerBillitStat extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    date_default_timezone_set("Europe/London");
    $model = new ModelBillit();
    $startTime = strtotime("midnight");
    $endTime = $startTime + 86399;
    $rawLogs = $model->GetLogsByDate($startTime, $endTime, true);
    $logs = $model->FormatLogs($rawLogs);
    $summary = $model->StatSummary($logs);

    return view('billitStats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'summary' => $summary,
      'weekday' => null,
      'reportType' => 'Summary' ]);
  }

  public function GetSummary(Request $request)
  {
    date_default_timezone_set("Europe/London");

    $validated = $request->validate([
      'reportType' => ['required', 'string'],
      'startDate' => ['required', 'date'],
      'endDate' => ['required', 'date'],
    ]);

    $startTime = strtotime($request->startDate);
    $endTime = strtotime($request->endDate);

    $model = new ModelBillit();

    if(!isset($startTime))
    {
      $startTime = strtotime("midnight");
    }
    if(!isset($endTime))
    {
      $endTime = $startTime;
    }

    $rawLogs = $model->GetLogsByDate($startTime, ($endTime + 86399), true);
    $logs = $model->FormatLogs($rawLogs);
    $summary = $model->StatSummary($logs);

    return view('billitStats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'summary' => $summary,
      'weekday' => null,
      'reportType' => $request->reportType ]);
  }

  public function GetWeekday(Request $request)
  {
    date_default_timezone_set("Europe/London");

    $validated = $request->validate([
      'reportType' => ['required', 'string'],
      'startDate' => ['required', 'date'],
      'endDate' => ['required', 'date'],
    ]);

    $startTime = strtotime($request->startDate);
    $endTime = strtotime($request->endDate);

    $model = new ModelBillit();

    if(!isset($startTime))
    {
      $startTime = strtotime("midnight");
    }
    if(!isset($endTime))
    {
      $endTime = $startTime;
    }

    $rawLogs = $model->GetLogsByDate($startTime, ($endTime + 86399), true);
    $logs = $model->FormatLogs($rawLogs);
    $weekday = $model->StatWeekday($logs);

    return view('billitStats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'summary' => null,
      'weekday' => $weekday,
      'reportType' => $request->reportType ]);
  }

  public function ChartWeekday(Request $request)
  {
    date_default_timezone_set("Europe/London");

    $validated = $request->validate([
      'startDate' => ['required', 'date'],
      'endDate' => ['required', 'date'],
    ]);

    $startTime = strtotime($request->startDate);
    $endTime = strtotime($request->endDate);

    $model = new ModelBillit();

    if(!isset($startTime))
    {
      $startTime = strtotime("midnight");
    }
    if(!isset($endTime))
    {
      $endTime = $startTime;
    }

    $rawLogs = $model->GetLogsByDate($startTime, ($endTime + 86399), true);
    $logs = $model->FormatLogs($rawLogs);
    $stats = $model->ChartSession($logs);

    return $stats;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}
