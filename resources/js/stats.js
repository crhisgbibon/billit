"use strict";

let getdatesbutton = document.getElementById("getdatesbutton");
getdatesbutton.onclick = function() { PostByDate('stats/GetDates'); };

let reportType = document.getElementById("reportType");
let startDate = document.getElementById("startDate");
let endDate = document.getElementById("endDate");
let sessionChart = document.getElementById("sessionChart");
let chart = undefined;

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
      Print(result);
    },
    error:function()
    {

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