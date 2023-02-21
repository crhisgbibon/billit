<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ModelBillit extends Model
{
  use HasFactory;

  protected $table = "logs";

  public function GetLogsByDate(int $startTime, int $endTime, $ascending)
  {
    $order = "desc";
    if($ascending === true) $order = "asc";
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    return $logs = DB::table('logs')
      ->where('user', '=', $id)
      ->where('hiddenRow', '=', 0)
      ->where('startTime', '>=', $startTime)
      ->where('endTime', '<=', $endTime)
      ->orWhere('endTime', '=', 0)
      ->orderBy('startTime', $order)
      ->get();
  }

  public function GetActiveSessions()
  {
    $id = Auth::user()->id;
    return $sessions = DB::table('logs')
      ->where('isSession', '=', 1)
      ->where('completed', '=', 0)
      ->where('user', '=', $id)
      ->where('hiddenRow', '=', 0)
      ->get();
  }

  public function AddSession()
  {
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    $now = time();
    DB::table('logs')->insert([
      'user' => $id,
      'isSession' => 1,
      'tag' => '',
      'colleague' => '',
      'reference' => '',
      'task' => '',
      'startTime' => $now,
      'endTime' => 0,
      'completed' => 0,
      'hiddenRow' => 0
    ]);
  }

  public function GetOpenTasks()
  {
    $id = Auth::user()->id;
    return $tasks = DB::table('logs')
      ->where('isSession', '=', 0)
      ->where('completed', '=', 0)
      ->where('user', '=', $id)
      ->where('hiddenRow', '=', 0)
      ->get();
  }

  public function CloseRecords($records)
  {
    $len = count($records);
    if($len > 0)
    {
      date_default_timezone_set("Europe/London");
      $id = Auth::user()->id;
      $now = time();
      for($i = 0; $i < $len; $i++)
      {
        DB::table('logs')
          ->where('uniqueIndex', "=", $records[$i]->uniqueIndex)
          ->where('user', "=", $id)
          ->update(['completed' => 1,
                    'endTime' => $now ]);
      }
    }
  }

  public function IsSession()
  {
    $id = Auth::user()->id;
    $liveSession = DB::table('logs')
      ->where('isSession', '=', 1)
      ->where('completed', '=', 0)
      ->where('user', '=', $id)
      ->where('hiddenRow', '=', 0)
      ->get();

    return count($liveSession) > 0 ? true : false;
  }

  public function AddItem()
  {
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    $now = time();
    DB::table('logs')->insert([
      'user' => $id,
      'isSession' => 0,
      'tag' => 'File',
      'colleague' => 'CG',
      'reference' => '',
      'task' => '',
      'startTime' => $now,
      'endTime' => 0,
      'completed' => 0,
      'hiddenRow' => 0
    ]);
  }

  public function GetLog($index)
  {
    $id = Auth::user()->id;
    return $tasks = DB::table('logs')
      ->where('uniqueIndex', '=', $index)
      ->limit(1)
      ->get();
  }

  public function RestartItem($item)
  {
    date_default_timezone_set("Europe/London");
    $now = time();
    DB::table('logs')->insert([
      'user' => $item->user,
      'isSession' => $item->isSession,
      'tag' => $item->tag,
      'colleague' => $item->colleague,
      'reference' => $item->reference,
      'task' => $item->task,
      'startTime' => $now,
      'endTime' => 0,
      'completed' => 0,
      'hiddenRow' => 0
    ]);
  }

  public function DeleteItem($item)
  {
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    try{
      DB::table('logs')
      ->where('uniqueIndex', "=", $item->index)
      ->where('user', "=", $id)
      ->where('isSession', "=", 0)
      ->update([
                'hiddenRow' => 1
              ]);
    }
    catch(\Illuminate\Database\QueryException $ex){
      return $ex;
    }
  }

  public function UpdateItem($item)
  {
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    try{
      DB::table('logs')
      ->where('uniqueIndex', "=", $item->index)
      ->where('user', "=", $id)
      ->where('isSession', "=", 0)
      ->update([
                'tag' => ($item->tag === null) ? "" : $item->tag,
                'colleague' => ($item->colleague === null) ? "" : $item->colleague,
                'reference' => ($item->reference === null) ? "" : $item->reference,
                'task' => ($item->task === null) ? "" : $item->task,
                'startTime' => ($item->startTime === null) ? "" : strtotime($item->startTime),
                'endTime' => ($item->endTime === null) ? "" : strtotime($item->endTime),
              ]);
    }
    catch(\Illuminate\Database\QueryException $ex){
      return $ex;
    }
  }

  public function UpdateSession($item)
  {
    date_default_timezone_set("Europe/London");
    $id = Auth::user()->id;
    try{
      DB::table('logs')
      ->where('uniqueIndex', "=", $item->index)
      ->where('user', "=", $id)
      ->where('isSession', "=", 1)
      ->update([
                'startTime' => ($item->startTime === null) ? "" : strtotime($item->startTime),
                'endTime' => ($item->endTime === null) ? "" : strtotime($item->endTime),
              ]);
    }
    catch(\Illuminate\Database\QueryException $ex){
      return $ex;
    }
  }

  public function FormatLogs($logs)
  {
    $l = count($logs);
    $now = strtotime("now");
    for($i = 0; $i < $l; $i++)
    {
      if($logs[$i]->endTime === "" || $logs[$i]->endTime === null || $logs[$i]->endTime === "0")
      {
        $logs[$i]->endTime = $now;
      }
    }
    return $logs;
  }

  private function ConvertSeconds($seconds) : string
  {
    $duration = "";

    $seconds = round($seconds);

    $remainder = (int)$seconds % 60;
    $minutes = ($seconds - $remainder) / 60;
    if($remainder < 10) $remainder = "0" . (string)$remainder;

    if($minutes > 60)
    {
      $minutesRemaining = $minutes % 60;
      $hours = ($minutes - $minutesRemaining) / 60;

      if($minutesRemaining < 10) $minutesRemaining = "0" . (string)$minutesRemaining;

      if($hours > 24)
      {
        $hoursRemaining = $hours % 24;
        $days = ($hours - $hoursRemaining) / 24;

        $duration = $days . " d " . $hoursRemaining . " h " . $minutesRemaining . " m";
      }
      else
      {
        $duration = $hours . " h " . $minutesRemaining . " m";
      }
    }
    else
    {
      if($remainder === "60")
      {
        $duration = "1:00";
      }
      else
      {
        $duration = $minutes . " m " . $remainder . " s";
      }
    }

    return $duration;
  }

  public function SecondsToTimeSinceMidnight($seconds)
  {
    $time = "";

    $seconds = round($seconds);

    $remainder = (int)$seconds % 60;
    $minutes = ($seconds - $remainder) / 60;
    if($remainder < 10) $remainder = "0" . (string)$remainder;

    if($minutes > 60)
    {
      $minutesRemaining = $minutes % 60;
      $hours = ($minutes - $minutesRemaining) / 60;

      if($minutesRemaining < 10) $minutesRemaining = "0" . (string)$minutesRemaining;

      if($hours > 24)
      {
        $hoursRemaining = $hours % 24;
        $days = ($hours - $hoursRemaining) / 24;

        $duration = $days . " d " . $hoursRemaining . " h " . $minutesRemaining . " m";
      }
      else
      {
        $duration = $hours . " h " . $minutesRemaining . " m";
      }
    }
    else
    {
      if($remainder === "60")
      {
        $duration = "1:00";
      }
      else
      {
        $duration = $minutes . " m " . $remainder . " s";
      }
    }

    return $time;
  }

  public function StatSummary($data)
  {
    $count = count($data);
    $output = [];

    if($count > 0)
    {
      date_default_timezone_set("Europe/London");

      $sessionSeconds = 0;
      $taskSeconds = 0;
      $tagSeconds = 0;
      $colleagueSeconds = 0;
      $referenceSeconds = 0;
      $emptySeconds = 0;

      $sumTags = [];
      $sumColleagues = [];
      $sumReferences = [];
      $sumSessions = [];
      $sessionStartEnd = [];

      for($i = 0; $i < $count; $i++)
      {
        $session = (int)$data[$i]->isSession;
        $start = (int)$data[$i]->startTime;
        $end = (int)$data[$i]->endTime;

        $tag = (string)$data[$i]->tag;
        $colleague = (string)$data[$i]->colleague;
        $reference = (string)$data[$i]->reference;

        $duration = $end - $start;

        if($session === 1)
        {
          $sessionSeconds += $duration;

          $sessionDay = date("Y-m-d", $start);
          if(array_key_exists($sessionDay, $sumSessions)) $sumSessions[$sessionDay]['duration'] += $duration;
          else $sumSessions[$sessionDay]['duration'] = $duration;

          if(array_key_exists($sessionDay, $sessionStartEnd))
          {
            $sessionStartEnd[$sessionDay]["end"] = $end;
          } 
          else
          {
            $sessionStartEnd[$sessionDay]["start"] = $start;
            $sessionStartEnd[$sessionDay]["end"] = $end;
          } 
        }
        else if($session === 0)
        {
          $taskSeconds += $duration;

          if(array_key_exists($tag, $sumTags)) $sumTags[$tag]['duration'] += $duration;
          else $sumTags[$tag]['duration'] = $duration;

          if(array_key_exists($colleague, $sumColleagues)) $sumColleagues[$colleague]['duration'] += $duration;
          else $sumColleagues[$colleague]['duration'] = $duration;

          if(array_key_exists($reference, $sumReferences)) $sumReferences[$reference]['duration'] += $duration;
          else $sumReferences[$reference]['duration'] = $duration;
        }
      }

      arsort($sumTags);
      arsort($sumColleagues);
      arsort($sumReferences);

      $logDays = count($sumSessions);

      $averageSession = $sessionSeconds / $logDays;
      $averageSessionDuration = $this->ConvertSeconds($averageSession);

      $averageTask = $taskSeconds / $logDays;
      $averageTaskDuration = $this->ConvertSeconds($averageTask);

      $emptySeconds = $sessionSeconds - $taskSeconds;
      $emptyDuration = $this->ConvertSeconds($emptySeconds);
      $averageEmpty = $emptySeconds / $logDays;
      $averageEmptyDuration = $this->ConvertSeconds($averageEmpty);

      $totalLogSeconds = 0;

      foreach($sumSessions as $key => $value)
      {
        $logStart = "";
        $logEnd = "";
        foreach($sessionStartEnd as $key1 => $value2)
        {
          if($key1 === $key)
          {
            $logStart = $value2["start"];
            $logEnd = $value2["end"];
            break;
          }
        }

        $sessionSeconds = (int)$logEnd - (int)$logStart;
        $totalLogSeconds += $sessionSeconds;
        $emptySeconds = $sessionSeconds - $value['duration'];
        $sumSessions[$key]['logDuration'] = $this->ConvertSeconds($sessionSeconds);
        $sumSessions[$key]['sessionDuration'] = $this->ConvertSeconds($value['duration']);
        $sumSessions[$key]['emptyDuration'] = $this->ConvertSeconds($emptySeconds);
      }

      $averageLog = $totalLogSeconds / $logDays;
      $averageLogDuration = $this->ConvertSeconds($averageLog);

      foreach($sumTags as $key => $value)
      {
        if($key === "--") $key = "Unassigned";
        $sumTags[$key]['fDuration'] = $this->ConvertSeconds($value['duration']);

        $tagSeconds += $value['duration'];

        $average = $value['duration'] / $logDays;
        $sumTags[$key]['avDuration'] = $this->ConvertSeconds($average);
      }

      foreach($sumColleagues as $key => $value)
      {
        if($key === "--") $key = "Unassigned";
        $sumColleagues[$key]['fDuration'] = $this->ConvertSeconds($value['duration']);

        $tagSeconds += $value['duration'];

        $average = $value['duration'] / $logDays;
        $sumColleagues[$key]['avDuration'] = $this->ConvertSeconds($average);
      }

      foreach($sumReferences as $key => $value)
      {
        if($key === "--") $key = "Unassigned";
        $sumReferences[$key]['fDuration'] = $this->ConvertSeconds($value['duration']);

        $tagSeconds += $value['duration'];

        $average = $value['duration'] / $logDays;
        $sumReferences[$key]['avDuration'] = $this->ConvertSeconds($average);
      }

      $output = [
        'sessionSeconds' => $sessionSeconds,
        'averageLogDuration' => $averageLogDuration,
        'taskSeconds' => $taskSeconds,
        'tagSeconds' => $tagSeconds,
        'colleagueSeconds' => $colleagueSeconds,
        'referenceSeconds' => $referenceSeconds,
        'emptySeconds' => $emptySeconds,
        'sumSessions' => $sumSessions,
        'sumTags' => $sumTags,
        'sumColleagues' => $sumColleagues,
        'sumReferences' => $sumReferences,
        'logDays' => $logDays,
        'averageSessionDuration' => $averageSessionDuration,
        'averageTaskDuration' => $averageTaskDuration,
        'averageEmptyDuration' => $averageEmptyDuration,
      ];

    }

    return $output;
  }

  public function StatWeekday($data)
  {
    $count = count($data);
    $output = [];

    if($count > 0)
    {
      date_default_timezone_set("Europe/London");

      $sessionStartEnd = [];

      for($i = 0; $i < $count; $i++)
      {
        $index = (int)$data[$i]->uniqueIndex;
        $start = (int)$data[$i]->startTime;
        $end = (int)$data[$i]->endTime;
        $duration = $end - $start;

        if((int)$data[$i]->isSession === 1)
        {
          $sessionDay = date("Y-m-d", $start);
          if(array_key_exists($sessionDay, $sessionStartEnd))
          {
            $sessionStartEnd[$sessionDay]["end"] = $end;
            $sessionStartEnd[$sessionDay]['sessionDuration'] += $duration;
          }
          else
          {
            $sessionStartEnd[$sessionDay]["start"] = $start;
            $sessionStartEnd[$sessionDay]["end"] = $end;
            $sessionStartEnd[$sessionDay]['sessionDuration'] = $duration;
            $sessionStartEnd[$sessionDay]["tag"]["File"] = 0;
            $sessionStartEnd[$sessionDay]["tag"]["Help"] = 0;
            $sessionStartEnd[$sessionDay]["tag"]["Misc"] = 0;
            $sessionStartEnd[$sessionDay]["colleague"] = [
              "AA" => 0,
              "AB" => 0,
              "AC" => 0,
              "AMB" => 0,
              "CG" => 0,
              "CF" => 0,
              "CHM" => 0,
              "CM" => 0,
              "CMC" => 0,
              "GEN" => 0,
              "GVM" => 0,
              "HH" => 0,
              "JS" => 0,
              "KA" => 0,
              "LB" => 0,
              "LR" => 0,
              "MB" => 0,
              "MC" => 0,
              "RL" => 0,
              "RT" => 0,
              "SM" => 0
            ];
          }
        }
        else if((int)$data[$i]->isSession === 0)
        {
          $tag = (string)$data[$i]->tag;
          $colleague = (string)$data[$i]->colleague;

          if(array_key_exists($sessionDay, $sessionStartEnd))
          {
            if(isset($data[$i]->tag))$sessionStartEnd[$sessionDay]["tag"][$tag] += $duration;
          }
          else
          {
            $sessionStartEnd[$sessionDay]["tag"]["File"] = 0;
            $sessionStartEnd[$sessionDay]["tag"]["Help"] = 0;
            $sessionStartEnd[$sessionDay]["tag"]["Misc"] = 0;
            $sessionStartEnd[$sessionDay]["tag"][$tag] += $duration;
          }
        }
      }

      $days = [];

      foreach($sessionStartEnd as $key => $value)
      {
        $weekDay = date("D", $sessionStartEnd[$key]["start"]);

        $startHours = date("H", $sessionStartEnd[$key]["start"]) * 60 * 60;
        $startMinutes = date("i", $sessionStartEnd[$key]["start"]) * 60;

        $endHours = date("H", $sessionStartEnd[$key]["end"]) * 60 * 60;
        $endMinutes = date("i", $sessionStartEnd[$key]["end"]) * 60;

        if(array_key_exists($weekDay, $days))
        {
          $days[$weekDay]["startHours"] += $startHours;
          $days[$weekDay]["startMinutes"] += $startMinutes;
          $days[$weekDay]["endHours"] += $endHours;
          $days[$weekDay]["endMinutes"] += $endMinutes;
          $days[$weekDay]["sessionDuration"] += $sessionStartEnd[$key]['sessionDuration'];

          $days[$weekDay]["tag"]["File"] += $sessionStartEnd[$key]["tag"]["File"];
          $days[$weekDay]["tag"]["Help"] += $sessionStartEnd[$key]["tag"]["Help"];
          $days[$weekDay]["tag"]["Misc"] += $sessionStartEnd[$key]["tag"]["Misc"];

          $days[$weekDay]["count"]++;
        }
        else
        {
          $days[$weekDay]["startHours"] = $startHours;
          $days[$weekDay]["startMinutes"] = $startMinutes;
          $days[$weekDay]["endHours"] = $endHours;
          $days[$weekDay]["endMinutes"] = $endMinutes;
          $days[$weekDay]["sessionDuration"] = $sessionStartEnd[$key]['sessionDuration'];

          $days[$weekDay]["tag"]["File"] = 0;
          $days[$weekDay]["tag"]["Help"] = 0;
          $days[$weekDay]["tag"]["Misc"] = 0;

          $days[$weekDay]["tag"]["File"] += $sessionStartEnd[$key]["tag"]["File"];
          $days[$weekDay]["tag"]["Help"] += $sessionStartEnd[$key]["tag"]["Help"];
          $days[$weekDay]["tag"]["Misc"] += $sessionStartEnd[$key]["tag"]["Misc"];

          $days[$weekDay]["count"] = 1;
        }
      }

      foreach($days as $key => $value)
      {
        $avStart = ( $days[$key]['startHours'] + $days[$key]['startMinutes'] ) / $days[$key]['count'];

        $avMinutesStart = floor( $avStart / 60 );
        $avHoursStart = floor( $avMinutesStart / 60 );
        $minutesRemainingStart = floor( $avMinutesStart - ( $avHoursStart * 60 ) );

        if($avHoursStart < 10) $avHoursStart = "0" . $avHoursStart;
        if($minutesRemainingStart < 10) $minutesRemainingStart = "0" . $minutesRemainingStart;

        $days[$key]['averageStart'] = $avHoursStart . ":" . $minutesRemainingStart;

        $avEnd = ( $days[$key]['endHours'] + $days[$key]['endMinutes'] ) / $days[$key]['count'];

        $avMinutesEnd = floor( $avEnd / 60 );
        $avHoursEnd = floor( $avMinutesEnd / 60 );
        $minutesRemainingEnd = floor( $avMinutesEnd - ( $avHoursEnd * 60 ) );

        if($avHoursEnd < 10) $avHoursEnd = "0" . $avHoursEnd;
        if($minutesRemainingEnd < 10) $minutesRemainingEnd = "0" . $minutesRemainingEnd;

        $days[$key]['averageEnd'] = $avHoursEnd . ":" . $minutesRemainingEnd;
        
        $avLength = $avEnd - $avStart;

        $avLengthMinutes = floor( $avLength / 60 );
        $avLengthHours = floor( $avLengthMinutes / 60 );
        $avLengthRemaining = floor( $avLengthMinutes - ( $avLengthHours * 60 ) );

        if($avLengthHours < 10) $avLengthHours = "0" . $avLengthHours;
        if($avLengthRemaining < 10) $avLengthRemaining = "0" . $avLengthRemaining;

        $days[$key]['averageLength'] = $avLengthHours . ":" . $avLengthRemaining;

        $avSession = $days[$key]['sessionDuration'] / $days[$key]['count'];

        $avSessionMinutes = floor( $avSession / 60 );
        $avSessionHours = floor( $avSessionMinutes / 60 );
        $avSessionRemaining = floor( $avSessionMinutes - ( $avSessionHours * 60 ) );

        if($avSessionHours < 10) $avSessionHours = "0" . $avSessionHours;
        if($avSessionRemaining < 10) $avSessionRemaining = "0" . $avSessionRemaining;

        $days[$key]['averageSession'] = $avSessionHours . ":" . $avSessionRemaining;

        $avBreak = $avLength - $avSession;

        $avBreakMinutes = floor( $avBreak / 60 );
        $avBreakHours = floor( $avBreakMinutes / 60 );
        $avBreakRemaining = floor( $avBreakMinutes - ( $avBreakHours * 60 ) );

        if($avBreakHours < 10) $avBreakHours = "0" . $avBreakHours;
        if($avBreakRemaining < 10) $avBreakRemaining = "0" . $avBreakRemaining;

        $days[$key]['averageBreak'] = $avBreakHours . ":" . $avBreakRemaining;


        if(isset($days[$key]['tag']['File']))
        {
          $avFile = $days[$key]['tag']['File'] / $days[$key]['count'];

          $avFileMinutes = floor( $avFile / 60 );
          $avFileHours = floor( $avFileMinutes / 60 );
          $avFileRemaining = floor( $avFileMinutes - ( $avFileHours * 60 ) );

          if($avFileHours < 10) $avFileHours = "0" . $avFileHours;
          if($avFileRemaining < 10) $avFileRemaining = "0" . $avFileRemaining;

          $days[$key]['averageFile'] = $avFileHours . ":" . $avFileRemaining;
        }

        if(isset($days[$key]['tag']['Help']))
        {
          $avHelp = $days[$key]['tag']['Help'] / $days[$key]['count'];

          $avHelpMinutes = floor( $avHelp / 60 );
          $avHelpHours = floor( $avHelpMinutes / 60 );
          $avHelpRemaining = floor( $avHelpMinutes - ( $avHelpHours * 60 ) );

          if($avHelpHours < 10) $avHelpHours = "0" . $avHelpHours;
          if($avHelpRemaining < 10) $avHelpRemaining = "0" . $avHelpRemaining;

          $days[$key]['averageHelp'] = $avHelpHours . ":" . $avHelpRemaining;
        }

        if(isset($days[$key]['tag']['Misc']))
        {
          $avMisc = $days[$key]['tag']['Misc'] / $days[$key]['count'];

          $avMiscMinutes = floor( $avMisc / 60 );
          $avMiscHours = floor( $avMiscMinutes / 60 );
          $avMiscRemaining = floor( $avMiscMinutes - ( $avMiscHours * 60 ) );

          if($avMiscHours < 10) $avMiscHours = "0" . $avMiscHours;
          if($avMiscRemaining < 10) $avMiscRemaining = "0" . $avMiscRemaining;

          $days[$key]['averageMisc'] = $avMiscHours . ":" . $avMiscRemaining;
        }

      }

      $formattedDays = array(
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
      );
      $sortedDays = [];
      foreach($formattedDays as $key)
      {
        if(isset($days[$key]))
        {
          $sortedDays[$key] = $days[$key];
        }
      }

      $output = [
        'days' => $sortedDays,
        'sessionStartEnd' => $sessionStartEnd,
      ];
    }

    return $output;
  }

  public function ChartWeekday($data)
  {
    $count = count($data);
    $output = [];

    if($count > 0)
    {
      date_default_timezone_set("Europe/London");

      $sessionStartEnd = [];

      for($i = 0; $i < $count; $i++)
      {
        if((int)$data[$i]->isSession === 1)
        {
          $index = (int)$data[$i]->uniqueIndex;
          $start = (int)$data[$i]->startTime;
          $end = (int)$data[$i]->endTime;

          $sessionDay = date("Y-m-d", $start);

          if(array_key_exists($sessionDay, $sessionStartEnd))
          {
            $sessionStartEnd[$sessionDay]["end"] = date("H:i:s", $end);
          }
          else
          {
            $sessionStartEnd[$sessionDay]["start"] = date("H:i:s", $start);
            $sessionStartEnd[$sessionDay]["end"] = date("H:i:s", $end);
          }
        }
      }
    }

    return $sessionStartEnd;
  }
}
