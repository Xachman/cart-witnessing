import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('fullCalendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin, listPlugin ],
    defaultView: 'listWeek',
    header: {
      left: 'dayGridMonth,listWeek,listDay',
      center: 'title',
      right: 'prev,next'
    },
    views: {
      listDay: { buttonText: 'day' },
      listWeek: { buttonText: 'list' },
      dayGridMonth: { buttonText: 'month' }
    },
    titleFormat: { year: 'numeric', month: 'short' },
    events:  (date, successCallback, failureCallback) => {
      var startDate = date.start;
      var endDate = date.end;
      $.ajax({
        url: '/calendar/full-calendar-data/'+startDate.getFullYear()+"-"+(startDate.getMonth()+1)+"-"+startDate.getDate()+'/'+endDate.getFullYear()+"-"+(endDate.getMonth()+1)+"-"+endDate.getDate(),
        datatType: 'json',
        success: function(data) {
          successCallback(data);
        }
      })
    },
    eventClick: (info) => {
      info.jsEvent.preventDefault();
      var scheduled = info.event.extendedProps.scheduled;
      var name = info.event.extendedProps.location_name;
      var location_id = info.event.extendedProps.location_id;
      console.log(info)
      if(scheduled) {
        deleteFromSchedule(info.event.url, info.event.start, info.event.end, name)
      }else{
        addToSchedule(info.event.url, info.event.start, info.event.end, name, location_id);
      }

    }
  });

  calendar.render();
  function addToSchedule(url, start, end, name, location_id) {
    var confirm = window.confirm("Are you sure you want to schedule "+name+" on "+start.getDate()+"/"+(start.getMonth()+1)+"/"+start.getFullYear()+" starting at "+formatAMPM(start)+"?");

    if(confirm) {
        $.post(url, {
          location_id: location_id,
          schedule_date: {
            year: start.getFullYear(),
            month: ("0"+(start.getMonth()+1)).slice(-2),
            day: start.getDate(),
          },
          start_time: {
            hour: ("0"+start.getHours()).slice(-2),
            minute: ("0"+start.getMinutes()).slice(-2)
          },
          end_time: {
            hour: ("0"+end.getHours()).slice(-2),
            minute: ("0"+end.getMinutes()).slice(-2)
          }
        }).done(() => {
          calendar.refetchEvents()
        })
    }
  }
  function deleteFromSchedule(url, start, end, name) {
    var confirm = window.confirm("Are you sure you want remove "+name+" on "+start.getDate()+"/"+(start.getMonth()+1)+"/"+start.getFullYear()+" starting at "+formatAMPM(start)+"?");

    if(confirm) {
        $.post(url).done( () => {
          calendar.refetchEvents()
        })

    }
  }

  function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
  }
});

