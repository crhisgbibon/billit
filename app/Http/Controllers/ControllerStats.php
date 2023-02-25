<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ModelBillit;

class ControllerStats extends Controller
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
    if(count($summary) === 0) $summary = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => null,
      'summary' => $summary,
      'session' => null,
      'task' => null,
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
    if(count($summary) === 0) $summary = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => null,
      'summary' => $summary,
      'session' => null,
      'task' => null,
      'weekday' => null,
      'reportType' => $request->reportType ]);
  }

  public function GetSession(Request $request)
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
    $session = $model->StatSummary($logs);
    if(count($session) === 0) $session = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => null,
      'summary' => null,
      'session' => $session,
      'task' => null,
      'weekday' => null,
      'reportType' => $request->reportType ]);
  }

  public function GetTask(Request $request)
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
    $task = $model->StatSummary($logs);
    if(count($task) === 0) $task = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => null,
      'summary' => null,
      'session' => null,
      'task' => $task,
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
    if(count($weekday) === 0) $weekday = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => null,
      'summary' => null,
      'session' => null,
      'task' => null,
      'weekday' => $weekday,
      'reportType' => $request->reportType ]);
  }

  public function GetColleague(Request $request)
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
    $colleague = $model->StatSummary($logs);
    if(count($colleague) === 0) $colleague = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => $colleague,
      'reference' => null,
      'summary' => null,
      'session' => null,
      'task' => null,
      'weekday' => null,
      'reportType' => $request->reportType ]);
  }

  public function GetReference(Request $request)
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
    $reference = $model->StatSummary($logs);
    if(count($reference) === 0) $reference = null;

    return view('stats', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'colleague' => null,
      'reference' => $reference,
      'summary' => null,
      'session' => null,
      'task' => null,
      'weekday' => null,
      'reportType' => $request->reportType ]);
  }
}
