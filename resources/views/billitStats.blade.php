@vite(['resources/js/stats.js'])

<x-app-layout>

  <x-slot name="appTitle">
    {{ __('billit : Stats') }}
  </x-slot>

  <x-slot name="appName">
    {{ __('billit : Stats') }}
  </x-slot>

  <x-slot name="header" class="flex-row items-center">
    <div class="flex w-full max-w-6xl flex-row justify-center mx-auto" style="height:calc(var(--vh) * 7.5)">
      <a id="LogButton" href="{{ url('/log') }}" class="h-full flex justify-center items-center mx-2 active:scale-95"><img class="w-3/4 h-3/4" src="{{ asset('storage/Assets/calendarLight.svg') }}"></a>
      <a id="SummaryButton" href="{{ url('/stats') }}" class="h-full flex justify-center items-center mx-2 active:scale-95"><img class="w-3/4 h-3/4" src="{{ asset('storage/Assets/chartLight.svg') }}"></a>
    </div>
  </x-slot>

  <div class="flex flex-col justify-center items-center max-w-xl mx-auto">
    <div class="w-full flex flex-row justify-center items-center" style="min-height:calc(var(--vh) * 7.5)">
      <input name="startDate" class="h-full text-center rounded" type="date" id="startDate" style="min-height:calc(var(--vh) * 7.5);min-width:50%"
      value='<?php
      if(isset($startDate))
      {
        echo date("Y-m-d", $startDate);
      }
      else
      {
        echo date("Y-m-d");
      }?>'>
      <input name="endDate" class="h-full text-center rounded" type="date" id="endDate" style="min-height:calc(var(--vh) * 7.5);min-width:50%"
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

    <div class="w-full flex flex-row justify-center items-center" style="min-height:calc(var(--vh) * 7.5)">
      <select id="reportType" class="h-full text-center rounded" style="min-height:calc(var(--vh) * 7.5);min-width:50%">
        <option <?php echo ($reportType === "Summary") ? "selected" : ""; ?>>Summary</option>
        <option <?php echo ($reportType === "Weekday") ? "selected" : ""; ?>>Weekday</option>
      </select>
      <x-secondary-button type="submit" class="flex justify-center items-center active:scale-95" style="min-height:calc(var(--vh) * 7.5);min-width:50%" id="getdatesbutton">
        <img src="{{ asset('storage/Assets/searchLight.svg') }}">
      </x-secondary-button>
    </div>
  </div>
  
  <div id="logOutput" class="w-full max-w-6xl h-full mx-auto">

    <x-billit-stats-output :summary="$summary" :weekday="$weekday"/>

  </div>

</x-app-layout>