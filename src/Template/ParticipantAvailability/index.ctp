<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Participant Availability'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participantAvailability index large-9 medium-8 columns content">
	<h3><?= __('Participant Availability') ?></h3>
	<a class="button tiny" href="/participant-availability">clear</a>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('day') ?></th>
                <th scope="col"><?= $this->Paginator->sort('participant_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
<!--                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>-->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
            foreach ($participantAvailability as $participantAvailability): ?>
            <tr>
                <td><?= $this->Number->format($participantAvailability->id) ?></td>
				<td><a href="/participant-availability?day=<?=$participantAvailability->day?>"><?= h($days[$participantAvailability->day])?></a></td>
                <td><a href="/participants/view/<?=$participantAvailability->participant_id?>"><?= h($participants[$participantAvailability->participant_id])?></a></td>
                <td><?= h($participantAvailability->start_time) ?></td>
                <td><?= h($participantAvailability->end_time) ?></td>
<!--                <td><?= h($participantAvailability->created) ?></td>
                <td><?= h($participantAvailability->modified) ?></td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participantAvailability->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participantAvailability->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participantAvailability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participantAvailability->id)]) ?>
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
