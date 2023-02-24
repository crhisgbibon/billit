<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ModelBillit;

class ControllerLog extends Controller
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
    $logs = $model->GetLogsByDate($startTime, $endTime, false);
    $isSession = $model->isSession();
    return view('log', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'logs' => $logs,
      'isSession' => $isSession ]);
  }

  public function GetDates(Request $request)
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

    $logs = $model->GetLogsByDate($startTime, ($endTime + 86399), false);

    $isSession = $model->isSession();

    return view('log', [
      'startDate' => $startTime,
      'endDate' => $endTime,
      'logs' => $logs,
      'isSession' => $isSession ]);
  }

  public function ToggleSession(Request $request)
  {
    $model = new ModelBillit();
    $activeSessions = $model->GetActiveSessions();

    if(count($activeSessions) === 0)
    {
      $model->AddSession();
    }
    else
    {
      $model->CloseRecords($activeSessions);
      $openTasks = $model->GetOpenTasks();
      $model->CloseRecords($openTasks);
    }

    $view = $this->GetDates($request);
    return $view;
  }

  public function NewItem(Request $request)
  {
    $model = new ModelBillit();

    $liveSession = $model->IsSession();

    if($liveSession === true)
    {
      $openTasks = $model->GetOpenTasks();
      $model->CloseRecords($openTasks);
      $model->AddItem();
      $view = $this->GetDates($request);
      return $view;
    }
    else
    {
      return "No Active Session.";
    }
  }

  public function CloseItem(Request $request)
  {
    $model = new ModelBillit();
    $openTasks = $model->GetOpenTasks();
    $model->CloseRecords($openTasks);
    $view = $this->GetDates($request);
    return $view;
  }

  public function RestartItem(Request $request)
  {
    $validated = $request->validate([
      'index' => ['required', 'string']
    ]);

    $model = new ModelBillit();
    $openTasks = $model->GetOpenTasks();
    $model->CloseRecords($openTasks);
    $items = $model->GetLog($request->index);
    $model->RestartItem($items[0]);
    
    $view = $this->GetDates($request);
    return $view;
  }

  public function DeleteItem(Request $request)
  {
    $validated = $request->validate([
      'index' => ['required', 'string']
    ]);

    $model = new ModelBillit();
    $debug = $model->DeleteItem($request);
    
    $view = $this->GetDates($request);
    return $view;
  }

  public function UpdateItem(Request $request)
  {
    $validated = $request->validate([
      'index' => ['required', 'string']
    ]);

    $model = new ModelBillit();
    $debug = $model->UpdateItem($request);
    
    $view = $this->GetDates($request);
    return $view;
  }

  public function UpdateSession(Request $request)
  {
    $validated = $request->validate([
      'index' => ['required', 'string']
    ]);

    $model = new ModelBillit();
    $debug = $model->UpdateSession($request);
    
    $view = $this->GetDates($request);
    return $view;
  }
}
