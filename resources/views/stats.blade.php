@vite(['resources/js/stats.js'])

<x-app-layout>

  <x-slot name="appTitle">
    {{ __('billit : stats') }}
  </x-slot>

  <x-slot name="appName">
    {{ __('billit : stats') }}
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
        <img src="{{ asset('storage/Assets/search.svg') }}">
      </x-secondary-button>
    </div>
  </div>
  
  <div id="logOutput" class="w-full max-w-6xl h-full mx-auto">

    <x-stats-output :summary="$summary" :weekday="$weekday"/>

  </div>

</x-app-layout>