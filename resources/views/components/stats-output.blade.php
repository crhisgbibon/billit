<style>
  :root{
    --header: rgb(175, 175, 245);
    --even: rgba(220,220,245,1);
    --odd: rgba(235,235,245,1);
  }
  .header{
    background-color: var(--header);
  }
  .stat:nth-of-type(even) {
    background: var(--even);
  }
  .stat:nth-of-type(odd) {
    background: var(--odd);
  }
</style>

@isset($summary)

  <div class="flex flex-col w-full px-2 max-w-3xl mx-auto justify-center items-center">

    <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Days:
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        <?php echo isset($summary["logDays"]) ? $summary["logDays"] : "" ?>
      </div>
    </div>

    <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        General
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Day Average
      </div>
    </div>

    <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Log
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        <?php echo isset($summary["averageLogDuration"]) ? $summary["averageLogDuration"] : "" ?>
      </div>
    </div>

    <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Session
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        <?php echo isset($summary["averageSessionDuration"]) ? $summary["averageSessionDuration"] : "" ?>
      </div>
    </div>

    <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Task
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        <?php echo isset($summary["averageTaskDuration"]) ? $summary["averageTaskDuration"] : "" ?>
      </div>
    </div>

    <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        Empty
      </div>
      <div class='flex justify-center items-center' style="min-width:45%;max-width:45%">
        <?php echo isset($summary["averageEmptyDuration"]) ? $summary["averageEmptyDuration"] : "" ?>
      </div>
    </div>

  </div>

@endisset

@isset($reference)
  <div class="flex flex-col w-full px-2 max-w-3xl mx-auto justify-center items-center">
    @isset($reference['sumReferences'])

      <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          References
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          Total
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          Day Average
        </div>
      </div>

      @foreach($reference['sumReferences'] as $key => $value)

        <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$key}}
          </div>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$value["fDuration"]}}
          </div>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$value["avDuration"]}}
          </div>
        </div>

      @endforeach

    @endisset
  </div>
@endisset

@isset($colleague)
  <div class="flex flex-col w-full px-2 max-w-3xl mx-auto justify-center items-center">
    @isset($colleague['sumColleagues'])

      <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          Colleagues
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          Total
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          Day Average
        </div>
      </div>

      @foreach($colleague['sumColleagues'] as $key => $value)

        <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$key}}
          </div>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$value["fDuration"]}}
          </div>
          <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
            {{$value["avDuration"]}}
          </div>
        </div>

      @endforeach

    @endisset
  </div>
@endisset

@isset($task)
  <div class="flex flex-col w-full px-2 max-w-3xl mx-auto justify-center items-center">
    @isset($task['sumTags'])
    <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
      <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
        Tags
      </div>
      <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
        Total
      </div>
      <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
        Day Average
      </div>
    </div>
    @foreach($task['sumTags'] as $key => $value)
      <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          {{$key}}
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          {{$value["fDuration"]}}
        </div>
        <div class='flex justify-center items-center' style="min-width:32%;max-width:32%">
          {{$value["avDuration"]}}
        </div>
      </div>
    @endforeach
  @endisset
  </div>
@endisset

@isset($session)
  @isset($session['sumSessions'])
    <div class="flex flex-col w-full px-2 max-w-3xl mx-auto justify-center items-center">
      <div class='header rounded-lg flex flex-row w-full max-w-3xl justify-center items-center py-2 my-2' style='max-width: 95%;'>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Days
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Log
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Session
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Break
        </div>
      </div>
      @foreach($session['sumSessions'] as $key => $value)
        <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2' style='max-width: 95%;'>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            {{$key}}
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            {{$value["logDuration"]}}
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            {{$value["sessionDuration"]}}
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            {{$value["emptyDuration"]}}
          </div>
        </div>
      @endforeach
    </div>
  @endisset
@endisset

@isset($weekday)

  <div class="flex flex-col w-full max-w-3xl mx-auto justify-center items-center">

    @isset($weekday['days'])

      <div class='header rounded-lg flex flex-row w-full justify-evenly items-center py-2 my-2'>
        <div class='flex justify-evenly items-center' style="min-width:10%;max-width:10%">
          Day
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          Count
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          Start
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          End
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          Log
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          Session
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          Break
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          File
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          Help
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          Misc
        </div>
      </div>

      @foreach($weekday['days'] as $key => $day)

      <div class='stat rounded-lg flex flex-row w-full justify-evenly items-center py-2 my-2'>
        <div class='flex justify-evenly items-center' style="min-width:10%;max-width:10%">
          {{$key}}
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["count"]}}
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["averageStart"]}}
        </div>
        <div class='flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["averageEnd"]}}
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["averageLength"]}}
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["averageSession"]}}
        </div>
        <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
          {{$weekday["days"][$key]["averageBreak"]}}
        </div>

        @if(isset($weekday["days"][$key]["averageFile"]))
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            {{$weekday["days"][$key]["averageFile"]}}
          </div>
        @else
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            0
          </div>
        @endif

        @if(isset($weekday["days"][$key]["averageHelp"]))
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            {{$weekday["days"][$key]["averageHelp"]}}
          </div>
        @else
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            0
          </div>
        @endif

        @if(isset($weekday["days"][$key]["averageMisc"]))
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            {{$weekday["days"][$key]["averageMisc"]}}
          </div>
        @else
          <div class='hidden sm:flex justify-center items-center' style="min-width:10%;max-width:10%">
            0
          </div>
        @endif

      </div>

      @endforeach

    @endisset

    @isset($weekday['sessionStartEnd'])

      <div class='header rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Day
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Date
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          Start
        </div>
        <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
          End
        </div>
      </div>

      @foreach($weekday['sessionStartEnd'] as $key => $value)

        <div class='stat rounded-lg flex flex-row w-full justify-center items-center py-2 my-2'>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            <?php echo date("D", $value["start"]);?>
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            {{$key}}
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            <?php echo date("H:i:s", $value["start"]);?>
          </div>
          <div class='flex justify-center items-center' style="min-width:25%;max-width:25%">
            <?php echo date("H:i:s", $value["end"]);?>
          </div>
        </div>

      @endforeach

    @endisset

  </div>

@endisset