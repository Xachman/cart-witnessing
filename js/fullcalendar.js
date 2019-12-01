import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('fullCalendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin ],
    defaultView: 'dayGridMonth',
    events: [{
      title: 'test',
      start: '2019-12-03',
      end: '2019-12-03',
    }]
  });

  calendar.render();
});