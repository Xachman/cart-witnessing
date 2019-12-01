import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('fullCalendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin ],
    defaultView: 'dayGridMonth',
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
    } 
  });

  calendar.render();
});