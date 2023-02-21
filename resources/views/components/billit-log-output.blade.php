@isset($logs)

  @foreach ($logs as $log)

    @if($log->isSession === 0)

      <div data-i={{$log->uniqueIndex}} class='toggleitembyid mx-auto flex flex-row p-2 m-2 justify-center items-center rounded-lg box-border border border-zinc-400' style="min-height:calc(var(--vh) * 5)">

        <div class='flex justify-center items-center truncate text-center' style="min-width:8%;max-width:8%">
          <?php echo ($log->tag !== "") ? $log->tag[0] : "-"; ?>
        </div>
        <div class='flex justify-start items-center truncate' style="min-width:24%;max-width:24%">
          <?php echo ($log->reference !== "") ? $log->reference : "-"; ?> <?php echo ($log->colleague !== "") ? $log->colleague : "-"; ?>
        </div>
        <div class='flex justify-center items-center truncate text-center' style="min-width:16%;max-width:16%">
          <?php
            date_default_timezone_set("Europe/London");
            echo date("H:i", $log->startTime);
          ?>
        </div>
        <div class='flex justify-center items-center text-center' style="min-width:16%;max-width:16%">
          <?php
            date_default_timezone_set("Europe/London");
            echo ((int)$log->endTime !== 0) ? date("H:i", $log->endTime) : "<button data-end='YES' class='closeitembutton rounded-lg px-2 border border-zinc-400'>x</button>";
          ?>
        </div>
        <div class='flex justify-center items-center text-center' style="min-width:16%;max-width:16%">
          <?php
            if((int)$log->endTime !== 0)
            {
              $durationSeconds = (int)$log->endTime - (int)$log->startTime;
              $durationRemainder = $durationSeconds % 60;
              $durationMinutes = ($durationSeconds - $durationRemainder) / 60;
              if($durationRemainder < 10 && $durationRemainder >= 0) $durationRemainder = "0" . (string)$durationRemainder;
              $durationRemainder = preg_replace('/\D+/', '', (string)$durationRemainder);
              echo $durationMinutes . ":" . $durationRemainder;
            }
            else
            {
              echo "<div data-endTimeCounter='YES' id='currentItem' data-stamp=$log->startTime class='px-2'>-</div>";
            }
          ?>
        </div>
        <div class='flex justify-center items-center text-center' style="min-width:16%;max-width:16%">
          <button class="restartitembutton flex justify-center items-center rounded-lg h-full active:scale-95 border border-zinc-400" data-i={{$log->uniqueIndex}}>
            <img data-restart="YES" src="{{ asset('storage/Assets/undo.svg') }}">
          </button>
        </div>

      </div>

      <div id=<?php echo $log->uniqueIndex . 'itemEdit' ?> data-item="YES" class="flex flex-col max-w-md mx-auto rounded" style="display:none;">

        <div class="flex flex-row max-w-sm justify-center items-center w-full my-2 mx-auto">
          <select class="mx-2 rounded flex justify-center items-center w-1/3 text-center"
          id=<?php echo $log->uniqueIndex . 'itemTag' ?>>
            <option <?php echo ($log->tag === "File") ? "selected" : ""; ?>>File</option>
            <option <?php echo ($log->tag === "Help") ? "selected" : ""; ?>>Help</option>
            <option <?php echo ($log->tag === "Misc") ? "selected" : ""; ?>>Misc</option>
          </select>
          <select class="mx-2 rounded flex justify-center items-center w-1/3 text-center"
          id=<?php echo $log->uniqueIndex . 'itemColleague' ?>>
            <option <?php echo ($log->colleague === "AA") ? "selected" : ""; ?>>AA</option>
            <option <?php echo ($log->colleague === "AB") ? "selected" : ""; ?>>AB</option>
            <option <?php echo ($log->colleague === "AC") ? "selected" : ""; ?>>AC</option>

            <option <?php echo ($log->colleague === "AMB") ? "selected" : ""; ?>>AMB</option>
            <option <?php echo ($log->colleague === "CG") ? "selected" : ""; ?>>CG</option>
            <option <?php echo ($log->colleague === "CF") ? "selected" : ""; ?>>CF</option>

            <option <?php echo ($log->colleague === "CHM") ? "selected" : ""; ?>>CHM</option>
            <option <?php echo ($log->colleague === "CM") ? "selected" : ""; ?>>CM</option>
            <option <?php echo ($log->colleague === "CMC") ? "selected" : ""; ?>>CMC</option>

            <option <?php echo ($log->colleague === "GEN") ? "selected" : ""; ?>>GEN</option>
            <option <?php echo ($log->colleague === "GVM") ? "selected" : ""; ?>>GVM</option>
            <option <?php echo ($log->colleague === "HH") ? "selected" : ""; ?>>HH</option>

            <option <?php echo ($log->colleague === "JS") ? "selected" : ""; ?>>JS</option>
            <option <?php echo ($log->colleague === "KA") ? "selected" : ""; ?>>KA</option>
            <option <?php echo ($log->colleague === "LB") ? "selected" : ""; ?>>LB</option>

            <option <?php echo ($log->colleague === "LR") ? "selected" : ""; ?>>LR</option>
            <option <?php echo ($log->colleague === "MB") ? "selected" : ""; ?>>MB</option>
            <option <?php echo ($log->colleague === "MC") ? "selected" : ""; ?>>MC</option>

            <option <?php echo ($log->colleague === "RL") ? "selected" : ""; ?>>RL</option>
            <option <?php echo ($log->colleague === "RT") ? "selected" : ""; ?>>RT</option>
            <option <?php echo ($log->colleague === "SM") ? "selected" : ""; ?>>SM</option>
            <option <?php echo ($log->colleague === "TO") ? "selected" : ""; ?>>TO</option>

            <option>TH</option>
          </select>
        </div>

        <input type="text" class="w-72 max-w-sm rounded my-2 mx-auto" placeholder="Reference"
        id=<?php echo $log->uniqueIndex . 'itemReference' ?>
        value='<?php echo ($log->reference !== "") ? $log->reference : ""; ?>'>

        <textarea class="w-72 max-w-sm mx-auto rounded my-2 mx-auto" placeholder="Notes" id=<?php echo $log->uniqueIndex . 'itemTask' ?>><?php echo($log->task !== "")?$log->task:"";?></textarea>

        <div class="flex flex-row max-w-sm justify-center items-center w-full my-2 mx-auto">
          <input type="time" class="mx-2 rounded flex justify-center items-center w-1/3 text-center"

          id=<?php echo $log->uniqueIndex . 'itemStart' ?>

          data-ymd='<?php echo date("Y-m-d", $log->startTime); ?>'
          data-seconds='<?php echo date("s", $log->startTime); ?>'

          value='<?php echo date("H:i", $log->startTime); ?>'>
          <div><img class="w-3/4 h-3/4" src="{{ asset('storage/Assets/chevronRight.svg') }}"></div>
          <input type="time" class="mx-2 rounded flex justify-center items-center w-1/3 text-center"
          id=<?php echo $log->uniqueIndex . 'itemEnd' ?>

          <?php echo ((int)$log->endTime === 0) ? "disabled" : ""; ?>

          data-ymd='<?php echo date("Y-m-d", $log->endTime); ?>'
          data-seconds='<?php echo date("s", $log->endTime); ?>'

          value='<?php echo ((int)$log->endTime === 0) ? "" : date("H:i", $log->endTime);; ?>'>
        </div>

        <div class="flex flex-row max-w-sm justify-center items-center w-full my-2 mx-auto">
          <button data-i={{$log->uniqueIndex}} class="updateitembutton mx-2 h-full rounded-lg border border-zinc-400 w-1/4 px-2" style="min-height:calc(var(--vh) * 5)">Update</button>

          <button data-i={{$log->uniqueIndex}} class="toggleitembyidclose mx-2 h-full rounded-lg border border-zinc-400 w-1/4 px-2" style="min-height:calc(var(--vh) * 5)">Close</button>
          
          <button data-i={{$log->uniqueIndex}} class="deleteitembutton mx-2 h-full rounded-lg border border-zinc-400 w-1/4 px-2" style="min-height:calc(var(--vh) * 5)">Delete</button>
        </div>

      </div>
        
    @else

      <div data-i={{$log->uniqueIndex}}
      class='togglesessionbuttonopen header mx-auto flex flex-row p-2 m-2 justify-center items-center rounded-lg box-border border border-zinc-400' data-i={{$log->uniqueIndex}} style="min-height:calc(var(--vh) * 5)">

        <div class='flex justify-center items-center' style="min-width:33%;max-width:33%">
          <?php
            date_default_timezone_set("Europe/London");
            echo date("H:i d/m", $log->startTime);
          ?>
        </div>
        <div class='flex justify-center items-center' style="min-width:33%;max-width:33%">
          <?php
            date_default_timezone_set("Europe/London");
            echo ((int)$log->endTime !== 0) ? date("H:i d/m", $log->endTime) : "-";
          ?>
        </div>
        <div class='flex justify-center items-center' style="min-width:33%;max-width:33%">
          <?php
            if((int)$log->endTime !== 0)
            {
              $durationSeconds = (int)$log->endTime - (int)$log->startTime;
              $durationRemainder = $durationSeconds % 60;
              $durationMinutes = ($durationSeconds - $durationRemainder) / 60;
              if($durationRemainder < 10 && $durationRemainder >= 0) $durationRemainder = "0" . (string)$durationRemainder;
              $durationRemainder = preg_replace('/\D+/', '', (string)$durationRemainder);
              echo $durationMinutes . ":" . $durationRemainder;
            }
            else
            {
              echo "<div data-endTimeCounter='YES' id='currentSession' data-stamp=$log->startTime class='rounded-full px-2'>-</div>";
            }
          ?>
        </div>

      </div>

      <div id=<?php echo $log->uniqueIndex . 'sessionEdit' ?> data-session="YES" class="flex flex-col max-w-xl mx-auto rounded" style="display:none;">

        <div class="flex flex-col max-w-xl justify-center items-center w-full my-2 mx-auto">
          <label class="mx-2 flex justify-center items-center w-full">Start:</label>
          <input type="datetime-local" class="mx-2 rounded flex justify-center items-center max-w-xs text-center"
  
          id=<?php echo $log->uniqueIndex . 'sessionStart' ?>
  
          data-ymd='<?php echo date("Y-m-d", $log->startTime); ?>'
          data-seconds='<?php echo date("s", $log->startTime); ?>'
  
          value='<?php 
          echo date("Y-m-d", $log->startTime);
          echo "T";
          echo date("H:i", $log->startTime);
          ?>'>
        </div>

        <div class="flex flex-col max-w-xl justify-center items-center w-full my-2 mx-auto">
          <label class="mx-2 flex justify-center items-center w-full">End:</label>
          <input type="datetime-local" class="mx-2 rounded flex justify-center items-center max-w-sm text-center"
          id=<?php echo $log->uniqueIndex . 'sessionEnd' ?>
  
          <?php echo ((int)$log->endTime === 0) ? "disabled" : ""; ?>
  
          data-ymd='<?php echo date("Y-m-d", $log->endTime); ?>'
          data-seconds='<?php echo date("s", $log->endTime); ?>'
  
          value='<?php 
            if((int)$log->endTime === 0)
            {
              echo "";
            }
            else
            {
              echo date("Y-m-d", $log->endTime);
              echo "T";
              echo date("H:i", $log->endTime);
            }?>'>
        </div>

        <div class="flex flex-row max-w-sm justify-center items-center w-full my-2 mx-auto">
          <label class="mx-2 flex justify-center items-center w-1/3">Session:</label>
          <select class="mx-2 rounded flex justify-center items-center w-1/3 text-center"
          id=<?php echo $log->uniqueIndex . 'sessionType' ?>>
            <option <?php echo "" ?>>Work</option>
          </select>
        </div>

        <div class="flex flex-row max-w-sm justify-center items-center w-full my-2 mx-auto">
          <button class="updatesessionbutton mx-2 h-full rounded-lg border border-zinc-400 w-1/3 px-2" style="min-height:calc(var(--vh) * 5)" data-i={{$log->uniqueIndex}}>Update</button>
  
          <button class="togglesessionbuttonclose mx-2 h-full rounded-lg border border-zinc-400 w-1/3 px-2" style="min-height:calc(var(--vh) * 5)" data-i={{$log->uniqueIndex}}>Close</button>
        </div>

      </div>

    @endif

  @endforeach

@else

  {{ __('No Data Found.') }}

@endisset