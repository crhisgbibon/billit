@vite(['resources/js/stats.js'])

<x-app-layout>

  <x-slot name="appTitle">
    {{ __('stats') }}
  </x-slot>

  <x-slot name="appName">
    {{ __('stats') }}
  </x-slot>

  <div class="flex flex-col justify-center items-center max-w-xl mx-auto">
    <div class="w-full flex flex-row justify-center items-center" style="min-height:calc(var(--vh) * 7.5)">
      <select id="reportType" class="h-full text-center rounded" style="min-height:calc(var(--vh) * 5);max-width:40%">
        <option <?php echo ($reportType === "summary") ? "selected" : ""; ?>>summary</option>
        <option <?php echo ($reportType === "colleague") ? "selected" : ""; ?>>colleague</option>
        <option <?php echo ($reportType === "reference") ? "selected" : ""; ?>>reference</option>
        <option <?php echo ($reportType === "session") ? "selected" : ""; ?>>session</option>
        <option <?php echo ($reportType === "task") ? "selected" : ""; ?>>task</option>
        <option <?php echo ($reportType === "weekday") ? "selected" : ""; ?>>weekday</option>
      </select>
      <input class='w-full text-center bg-white outline-none	cursor-pointer' type="clock" id="clock" readonly style="width:40%">
      <x-secondary-button type="submit" class="flex justify-center items-center active:scale-95" style="min-height:calc(var(--vh) * 5);min-width:10%" id="getdatesbutton">
        <img src="{{ asset('storage/Assets/search.svg') }}">
      </x-secondary-button>
    </div>
  </div>

  <div class="flex flex-col justify-center items-center max-w-xl mx-auto" id='TIME_PANEL'>
    <div class="w-full flex flex-col sm:flex-row justify-evenly items-center" style="min-height:calc(var(--vh) * 7.5)">
      <input name="startDate" class="text-center rounded my-2 sm:my-0" type="date" id="startDate" style="min-height:calc(var(--vh) * 5);"
      value='<?php
      if(isset($startDate))
      {
        echo date("Y-m-d", $startDate);
      }
      else
      {
        echo date("Y-m-d");
      }?>'>
      <div class="flex justify-center items-center my-2 sm:my-0">
        <img src="{{ asset('storage/Assets/chevronRight.svg') }}">
      </div>
      <input name="endDate" class="text-center rounded my-2 sm:my-0" type="date" id="endDate" style="min-height:calc(var(--vh) * 5);"
      value='<?php
      if(isset($endDate))
      {
        echo date("Y-m-d", $endDate);
      }
      else
      {
        echo date("Y-m-d");
      }?>'>
    </div>
  </div>
  
  <div id="logOutput" class="w-full max-w-6xl h-full mx-auto">

    <x-stats-output :summary="$summary" :weekday="$weekday" :session="$session" :task="$task" :colleague="$colleague" :reference="$reference"/>

  </div>

</x-app-layout>