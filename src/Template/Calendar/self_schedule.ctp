<?php if (isset($participant)) { ?>

<div class="calendar_nav">
<a href="/calendar/self-schedule/<?=$calendarData['lastMonth'] ?>" class="last-month nav-button">Last Month</a>
<a href="/calendar/self-schedule/<?=$calendarData['nextMonth']?>" class="next-month nav-button">Next Month</a>
</div>
<div><?=$participant->first_name?> <?=$participant->last_name?></div>
<div id="fullCalendar"></div>
<?php
$this->Calendar->displaySelfScheduleCalendar($calendarData, $participant);
}else{
    ?>
<div class="users form columns medium-offset-3 medium-6">
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email') ?></legend>
        <?= $this->Form->input('email') ?>
    </fieldset>
<?= $this->Form->button(__('Submit`')); ?>
<?= $this->Form->end() ?>
</div>
    <?php
}
