<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participant Availability'), ['action' => 'edit', $participantAvailability->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participant Availability'), ['action' => 'delete', $participantAvailability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participantAvailability->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participant Availability'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant Availability'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participantAvailability view large-9 medium-8 columns content">
    <h3><?= h($participantAvailability->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $participantAvailability->has('location') ? $this->Html->link($participantAvailability->location->name, ['controller' => 'Locations', 'action' => 'view', $participantAvailability->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Participant') ?></th>
            <td><?= $participantAvailability->has('participant') ? $this->Html->link($participantAvailability->participant->id, ['controller' => 'Participants', 'action' => 'view', $participantAvailability->participant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participantAvailability->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($participantAvailability->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($participantAvailability->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($participantAvailability->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($participantAvailability->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Notes') ?></h4>
        <?= $this->Text->autoParagraph(h($participantAvailability->notes)); ?>
    </div>
</div>
