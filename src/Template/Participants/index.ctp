<nav class="large-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participants index large-9  columns content">
    <h3><?= __('Participants') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
<!--                <th scope="col"><?= $this->Paginator->sort('id') ?></th>-->
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
<!--                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>-->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
            <tr>
<!--                <td><?= $this->Number->format($participant->id) ?></td>-->
                <td><?= h($participant->first_name) ?></td>
                <td><?= h($participant->last_name) ?></td>
                <td><?= h($participant->title) ?></td>
                <td><?= h($participant->email) ?></td>
                <td><?= h($participant->phone) ?></td>
<!--                <td><?= h($participant->created) ?></td>
                <td><?= h($participant->modified) ?></td>-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participant->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participant->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?>
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
