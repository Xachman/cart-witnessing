<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Outcome'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outcomes index large-9 medium-8 columns content">
    <h3><?= __('Outcomes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('books') ?></th>
                <th scope="col"><?= $this->Paginator->sort('magazines') ?></th>
                <th scope="col"><?= $this->Paginator->sort('brochures') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tracts') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contact_cards') ?></th>
                <th scope="col"><?= $this->Paginator->sort('videos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('return_visits') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bible_studies') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_worked') ?></th>
<!--                 <th scope="col"><?= $this->Paginator->sort('created') ?></th> -->
<!--                 <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($outcomes as $outcome): ?>
            <tr>
                <td><?= $this->Number->format($outcome->id) ?></td>
                <td><?= $outcome->has('location') ? $this->Html->link($outcome->location->name, ['controller' => 'Locations', 'action' => 'view', $outcome->location->id]) : '' ?></td>
                <td><?= $this->Number->format($outcome->books) ?></td>
                <td><?= $this->Number->format($outcome->magazines) ?></td>
                <td><?= $this->Number->format($outcome->brochures) ?></td>
                <td><?= $this->Number->format($outcome->tracts) ?></td>
                <td><?= $this->Number->format($outcome->contact_cards) ?></td>
                <td><?= $this->Number->format($outcome->videos) ?></td>
                <td><?= $this->Number->format($outcome->return_visits) ?></td>
                <td><?= $this->Number->format($outcome->bible_studies) ?></td>
                <td><?= h($outcome->date_worked) ?></td>
                <!--
                  <td><?= h($outcome->created) ?></td>
                  <td><?= h($outcome->modified) ?></td>
                -->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $outcome->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outcome->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outcome->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outcome->id)]) ?>
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
