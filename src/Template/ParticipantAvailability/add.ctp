<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Participant Availability'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participantAvailability form large-9 medium-8 columns content">
    <?= $this->Form->create($participantAvailability) ?>
    <fieldset>
        <legend><?= __('Add Participant Availability') ?></legend>
        <?php
            echo $this->Form->control('day', ['options' => $days, 'empty' => false]);
            echo $this->Form->control('participant_id', ['options' => $participants, 'empty' => false]);
            echo $this->Form->control('start_time', ['empty' => true]);
            echo $this->Form->control('end_time', ['empty' => true]);
            echo $this->Form->control('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
