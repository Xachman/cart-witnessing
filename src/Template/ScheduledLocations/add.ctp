<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Scheduled Locations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="scheduledLocations form large-9 medium-8 columns content">
    <?= $this->Form->create($scheduledLocation) ?>
    <fieldset>
        <legend><?= __('Add Scheduled Location') ?></legend>
        <?php
            echo $this->Form->input('location_id', ['options' => $locations, 'empty' => true, 'default' => $locationId]);
            echo $this->Form->input('participant_id', ['options' => $participants, 'empty' => true]);
            echo $this->Form->input('schedule_date', ['empty' => true, 'default' => $selectedDate]);
            echo $this->Form->input('start_time', ['empty' => true]);
            echo $this->Form->input('end_time', ['empty' => true]);
            echo $this->Form->input('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
