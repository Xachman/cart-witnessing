<div class="calendar_nav">
<a href="/calendar/month/<?=$calendarData['lastMonth'] ?>" class="last-month nav-button">Last Month</a>
<a href="/calendar/static-views/month/<?=$calendarData['currentMonth']?>" class="last-month nav-button" />Printable</a>
<a href="/calendar/month/<?=$calendarData['nextMonth']?>" class="next-month nav-button">Next Month</a>
</div>
<?php
$this->Calendar->displayCalendar($calendarData);
