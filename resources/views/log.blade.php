@vite(['resources/js/log.js'])

<x-app-layout>

  <style>
    :root{
      --header: rgb(175, 175, 245);
      --even: rgba(220,220,245,1);
      --odd: rgba(235,235,245,1);
    }
    .header{
      background-color: var(--header);
    }
  </style>

  <x-slot name="appTitle">
    {{ __('log') }}
  </x-slot>

  <x-slot name="appName">
    {{ __('log') }}
  </x-slot>

  <div class="flex flex-col justify-center items-center max-w-xl mx-auto">
    <div class="w-full flex flex-row justify-center items-center" style="min-height:calc(var(--vh) * 7.5)">
      <x-session-button :session="$isSession"/>
      <input class='text-center bg-white outline-none	cursor-pointer' type="clock" id="clock" readonly style="min-width:30%">
      @if($isSession === true)
        <x-secondary-button class='flex justify-center items-center active:scale-95 cursor-pointer' style="min-height:calc(var(--vh) * 5);min-width:10%" id="newitembutton">
          <img src="{{ asset('storage/Assets/plus.svg') }}">
        </x-secondary-button>
      @else
        <x-secondary-button class='flex justify-center items-center active:scale-95 cursor-auto' style="min-height:calc(var(--vh) * 5);min-width:10%" id="">
          <img src="{{ asset('storage/Assets/x.svg') }}">
        </x-secondary-button>
      @endif
    </div>
  </div>

  <div class="flex flex-col justify-center items-center max-w-xl mx-auto" id='TIME_PANEL'>
    <div class="w-full flex flex-col sm:flex-row justify-evenly items-center" style="min-height:calc(var(--vh) * 7.5)">
      <input name="startDate" class="text-center rounded my-2 sm:my-0" type="date" id="startDate" style="min-height:calc(var(--vh) * 5);max-width:35%"
      value='<?php
      if(isset($startDate))
      {
        echo date("Y-m-d", $startDate);
      }
      else
      {
        echo date("Y-m-d");
      }?>'>
      <div class="flex justify-center items-center">
        <img src="{{ asset('storage/Assets/chevronRight.svg') }}">
      </div>
      <input name="endDate" class="text-center rounded my-2 sm:my-0" type="date" id="endDate" style="min-height:calc(var(--vh) * 5);max-width:35%"
      value='<?php
      if(isset($endDate))
      {
        echo date("Y-m-d", $endDate);
      }
      else
      {
        echo date("Y-m-d");
      }?>'>
      <x-secondary-button type="submit" class="flex justify-center items-center active:scale-95 my-2 sm:my-0" style="min-height:calc(var(--vh) * 5);min-width:10%" id="getdatesbutton">
        <img src="{{ asset('storage/Assets/search.svg') }}">
      </x-secondary-button>
    </div>
  </div>
  
  <div id="logOutput" class="w-full max-w-6xl h-full mx-auto">

    <x-log-output :logs="$logs" :session="$isSession"/>

  </div>

</x-app-layout>