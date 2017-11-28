<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Location'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locations index large-9 medium-8 columns content">
    <h3><?= __('Locations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
<!--                <th scope="col"><?= $this->Paginator->sort('id') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('day') ?></th>
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
            foreach ($locations as $location): ?>
            <tr>
<!--                <td><?= $this->Number->format($location->id) ?></td>-->
                <td><?= h($location->name) ?></td>
                <td><?= $days[$location->day] ?></td>
                <td><?= h($location->start_time) ?></td>
                <td><?= h($location->end_time) ?></td>
<!--                <td><?= h($location->created) ?></td>
                <td><?= h($location->modified) ?></td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $location->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?>
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
