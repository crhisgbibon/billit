"use strict";

let clock = document.getElementById("clock");
let TIME_PANEL = document.getElementById('TIME_PANEL');

let timeOut = undefined;
let interval = undefined;

let getdatesbutton = document.getElementById("getdatesbutton");
getdatesbutton.onclick = function() { PostByDate('stats/GetDates'); };

let reportType = document.getElementById("reportType");
let startDate = document.getElementById("startDate");
let endDate = document.getElementById("endDate");
let sessionChart = document.getElementById("sessionChart");
let chart = undefined;

clock.onclick = function() { TogglePanel(TIME_PANEL); };

TogglePanel(TIME_PANEL);

function TogglePanel(panel)
{
  if(panel.style.display === '') panel.style.display = 'none';
  else panel.style.display = '';
}

function StartClock()
{
  clock.value = TimestampToDatetimeInputString(Date.now());
  interval = setInterval(GetNow, 1000);
}

function GetNow()
{
  let now = Date.now();
  clock.value = TimestampToDatetimeInputString(now);
}

function TimestampToDatetimeInputString(timestamp)
{
  const date = new Date((timestamp + GetTimeZoneOffsetInMs()));
  return date.toISOString().slice(11, 19);
}

function GetTimeZoneOffsetInMs()
{
  return new Date().getTimezoneOffset() * -60 * 1000;
}

function PostByDate(command)
{
  let url = command + "/" + reportType.value;
  $.ajax(
  {
    method: "POST",
    url: url,
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      reportType:reportType.value,
      startDate:startDate.value,
      endDate:endDate.value
    },
    success:function(result)
    {
      console.log(result);
      Print(result);
    },
    error:function(result)
    {
      console.log(result);
    }
  });
}

function Print(result)
{
  document.body.innerHTML = result;
  reportType = document.getElementById("reportType");
  startDate = document.getElementById("startDate");
  endDate = document.getElementById("endDate");
  sessionChart = document.getElementById("sessionChart");
  let getdatesbutton = document.getElementById("getdatesbutton");
  getdatesbutton.onclick = function() { PostByDate('stats/GetDates'); };

  clock = document.getElementById("clock");
  TIME_PANEL = document.getElementById('TIME_PANEL');

  clearInterval(interval);

  timeOut = undefined;
  interval = undefined;

  clock.onclick = function() { TogglePanel(TIME_PANEL); };

  TogglePanel(TIME_PANEL);
  StartClock();
}

function GetSessionChart()
{
  let url = "stats/GetDates/Session/Chart";
  $.ajax(
  {
    method: "POST",
    url: url,
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      startDate:startDate.value,
      endDate:endDate.value
    },
    success:function(result)
    {
      FormatChartLine(result);
    },
    error:function()
    {

    }
  });
}

document.addEventListener("DOMContentLoaded", StartClock);