<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $scheduledLocation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $scheduledLocation->id)]
            )
        ?></li>
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
        <legend><?= __('Edit Scheduled Location') ?></legend>
        <?php
            echo $this->Form->control('location_id', ['options' => $locations, 'empty' => true]);
            echo $this->Form->control('participant_id', ['options' => $participants, 'empty' => true]);
            echo $this->Form->control('schedule_date', ['empty' => true]);
            echo $this->Form->control('start_time', ['empty' => true]);
            echo $this->Form->control('end_time', ['empty' => true]);
            echo $this->Form->control('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
