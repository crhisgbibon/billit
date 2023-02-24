"use strict";

let clock = document.getElementById("clock");
let startDate = document.getElementById("startDate");
let endDate = document.getElementById("endDate");
let currentItem = document.getElementById("currentItem");
let currentSession = document.getElementById("currentSession");

let TIME_PANEL = document.getElementById('TIME_PANEL');

let timeOut = undefined;
let interval = undefined;

TogglePanel(TIME_PANEL);

function TogglePanel(panel)
{
  if(panel.style.display === '') panel.style.display = 'none';
  else panel.style.display = '';
}

function ToggleItemById(ref)
{
  let item = document.getElementById(ref);
  if(item.dataset.restart === "YES" || item.dataset.end === "YES") return;
  if(item.style.display == "none")
  {
    item.style.display = "";
    if(item.dataset.item === "YES")
    {
      item.scrollIntoView();
    }
  }
  else
  {
    item.style.display = "none";
  }
}

function ToggleSessionById(ref)
{
  let item = document.getElementById(ref);
  if(item.dataset.restart === "YES" || item.dataset.end === "YES") return;
  if(item.style.display == "none")
  {
    item.style.display = "";
    if(item.dataset.session === "YES")
    {
      item.scrollIntoView();
    }
  }
  else
  {
    item.style.display = "none";
  }
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
  if(currentItem !== null && currentItem !== undefined)
  {
    let d = new Date();
    let nowSeconds = Math.floor(d.getTime() / 1000);
    let seconds = nowSeconds - currentItem.dataset.stamp;
    let remainder = seconds % 60;
    let minutes = (seconds - remainder) / 60;
    let formattedSeconds = remainder;
    if(remainder < 10) formattedSeconds = "0" + remainder;
    currentItem.innerHTML = minutes + ":" + formattedSeconds;
  }
  if(currentSession !== null && currentSession !== undefined)
  {
    let d = new Date();
    let nowSeconds = Math.floor(d.getTime() / 1000);
    let seconds = nowSeconds - currentSession.dataset.stamp;
    let remainder = seconds % 60;
    let minutes = (seconds - remainder) / 60;
    let formattedSeconds = remainder;
    if(remainder < 10) formattedSeconds = "0" + remainder;
    currentSession.innerHTML = minutes + ":" + formattedSeconds;
  }
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
  $.ajax(
  {
    method: "POST",
    url: command,
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
      console.log(result);
      Print(result);
    },
    error:function(result)
    {
      console.log(result);
    }
  });
}

function Restart(index)
{
  $.ajax(
  {
    method: "POST",
    url: "/log/RestartItem",
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      index:index,
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

function Delete(index)
{
  $.ajax(
  {
    method: "POST",
    url: "/log/DeleteItem",
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      index:index,
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

function UpdateItem(index)
{
  let start = document.getElementById(index + "itemStart");
  let end = document.getElementById(index + "itemEnd");
  let newEndTime = 0;
  if(end.disabled === false) newEndTime = end.dataset.ymd + " " + end.value + ":" + end.dataset.seconds;
  let newStartTime = start.dataset.ymd + " " + start.value + ":" + start.dataset.seconds;
  $.ajax(
  {
    method: "POST",
    url: '/log/UpdateItem',
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      index:index,
      tag:document.getElementById(index + "itemTag").value,
      colleague:document.getElementById(index + "itemColleague").value,
      reference:document.getElementById(index + "itemReference").value,
      task:document.getElementById(index + "itemTask").value,
      startTime:newStartTime,
      endTime:newEndTime,
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

function UpdateSession(index)
{
  let start = document.getElementById(index + "sessionStart");
  let end = document.getElementById(index + "sessionEnd");
  let newEndTime = 0;
  if(end.disabled === false) newEndTime = end.value;
  let newStartTime = start.value;

  $.ajax(
  {
    method: "POST",
    url: '/log/UpdateSession',
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      index:index,
      startTime:newStartTime,
      endTime:newEndTime,
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
  if(result === "No Active Session.") return;
  document.body.innerHTML = result;
  ReAssign();
}

function ReAssign()
{
  clock = document.getElementById("clock");
  startDate = document.getElementById("startDate");
  endDate = document.getElementById("endDate");
  currentItem = document.getElementById("currentItem");
  currentSession = document.getElementById("currentSession");
  TIME_PANEL = document.getElementById('TIME_PANEL');

  clock.onclick = function() { TogglePanel(TIME_PANEL); };

  let getdatesbutton = document.getElementById("getdatesbutton");
  getdatesbutton.onclick = function() { PostByDate('log/GetDates'); };

  let newitembutton = document.getElementById("newitembutton");
  if(newitembutton) newitembutton.onclick = function() { PostByDate('log/NewItem'); };

  let toggleitembyid = document.getElementsByClassName("toggleitembyid");
  for(let i = 0; i < toggleitembyid.length; i++)
  {
    let id = toggleitembyid[i].dataset.i;
    toggleitembyid[i].onclick = function() { ToggleItemById(id + "itemEdit"); };
  }
  
  let restartitembutton = document.getElementsByClassName("restartitembutton");
  for(let i = 0; i < restartitembutton.length; i++)
  {
    let id = restartitembutton[i].dataset.i;
    restartitembutton[i].onclick = function() { Restart(id); };
  }
  
  let updateitembutton = document.getElementsByClassName("updateitembutton");
  for(let i = 0; i < updateitembutton.length; i++)
  {
    let id = updateitembutton[i].dataset.i;
    updateitembutton[i].onclick = function() { UpdateItem(id); };
  }
  
  let toggleitembyidclose = document.getElementsByClassName("toggleitembyidclose");
  for(let i = 0; i < toggleitembyidclose.length; i++)
  {
    let id = toggleitembyidclose[i].dataset.i;
    toggleitembyidclose[i].onclick = function() { ToggleItemById(id + "itemEdit"); };
  }
  
  let deleteitembutton = document.getElementsByClassName("deleteitembutton");
  for(let i = 0; i < deleteitembutton.length; i++)
  {
    let id = deleteitembutton[i].dataset.i;
    deleteitembutton[i].onclick = function() { Delete(id); };
  }
  
  let togglesessionbutton = document.getElementsByClassName("togglesessionbutton");
  for(let i = 0; i < togglesessionbutton.length; i++)
  {
    togglesessionbutton[i].onclick = function() { PostByDate('log/ToggleSession'); };
  }
  
  let togglesessionbuttonopen = document.getElementsByClassName("togglesessionbuttonopen");
  for(let i = 0; i < togglesessionbuttonopen.length; i++)
  {
    let id = togglesessionbuttonopen[i].dataset.i;
    togglesessionbuttonopen[i].onclick = function() { ToggleSessionById(id + "sessionEdit"); };
  }
  
  let updatesessionbutton = document.getElementsByClassName("updatesessionbutton");
  for(let i = 0; i < updatesessionbutton.length; i++)
  {
    let id = updatesessionbutton[i].dataset.i;
    updatesessionbutton[i].onclick = function() { UpdateSession(id); };
  }
  
  let togglesessionbuttonclose = document.getElementsByClassName("togglesessionbuttonclose");
  for(let i = 0; i < togglesessionbuttonclose.length; i++)
  {
    let id = togglesessionbuttonclose[i].dataset.i;
    togglesessionbuttonclose[i].onclick = function() { ToggleSessionById(id + "sessionEdit"); };
  }
  
  let closeitembutton = document.getElementsByClassName("closeitembutton");
  for(let i = 0; i < closeitembutton.length; i++)
  {
    closeitembutton[i].onclick = function() { PostByDate(`log/CloseItem`); };
  }
}

document.addEventListener("DOMContentLoaded", StartClock);
document.addEventListener("DOMContentLoaded", ReAssign);