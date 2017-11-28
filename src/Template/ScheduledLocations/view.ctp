<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Scheduled Location'), ['action' => 'edit', $scheduledLocation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Scheduled Location'), ['action' => 'delete', $scheduledLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scheduledLocation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Scheduled Locations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scheduled Location'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="scheduledLocations view large-9 medium-8 columns content">
    <h3><?= h($scheduledLocation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $scheduledLocation->has('location') ? $this->Html->link($scheduledLocation->location->name, ['controller' => 'Locations', 'action' => 'view', $scheduledLocation->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Participant') ?></th>
            <td><?= $scheduledLocation->has('participant') ? $this->Html->link($scheduledLocation->participant->id, ['controller' => 'Participants', 'action' => 'view', $scheduledLocation->participant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($scheduledLocation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule Date') ?></th>
            <td><?= h($scheduledLocation->schedule_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($scheduledLocation->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($scheduledLocation->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($scheduledLocation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($scheduledLocation->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Notes') ?></h4>
        <?= $this->Text->autoParagraph(h($scheduledLocation->notes)); ?>
    </div>
</div>
