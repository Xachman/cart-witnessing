<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participantAvailability->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participantAvailability->id)]
            )
        ?></li>
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
        <legend><?= __('Edit Participant Availability') ?></legend>
        <?php
            echo $this->Form->input('day', ['options' => $days, 'empty' => false]);
            echo $this->Form->input('participant_id', ['options' => $participants, 'empty' => true]);
            echo $this->Form->input('start_time', ['empty' => true]);
            echo $this->Form->input('end_time', ['empty' => true]);
            echo $this->Form->input('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
