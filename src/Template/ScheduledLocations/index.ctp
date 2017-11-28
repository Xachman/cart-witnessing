<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Scheduled Location'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="scheduledLocations index large-9 medium-8 columns content">
    <h3><?= __('Scheduled Locations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('participant_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scheduledLocations as $scheduledLocation): ?>
            <tr>
                <td><?= $this->Number->format($scheduledLocation->id) ?></td>
                <td><?= $scheduledLocation->has('location') ? $this->Html->link($scheduledLocation->location->name, ['controller' => 'Locations', 'action' => 'view', $scheduledLocation->location->id]) : '' ?></td>
                <td><?= h($participants[$scheduledLocation->participant_id])?></td>
		<td><?= h($scheduledLocation->schedule_date) ?></td>
                <td><?= h($scheduledLocation->start_time) ?></td>
                <td><?= h($scheduledLocation->end_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $scheduledLocation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $scheduledLocation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $scheduledLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scheduledLocation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
