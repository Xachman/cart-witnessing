<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailAttachments index large-9 medium-8 columns content">
    <h3><?= __('Email Attachments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailAttachments as $emailAttachment): ?>
            <tr>
                <td><?= $this->Number->format($emailAttachment->id) ?></td>
                <td><?= $emailAttachment->has('email') ? $this->Html->link($emailAttachment->email->id, ['controller' => 'Emails', 'action' => 'view', $emailAttachment->email->id]) : '' ?></td>
                <td><?= h($emailAttachment->name) ?></td>
                <td><?= h($emailAttachment->created) ?></td>
                <td><?= h($emailAttachment->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailAttachment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailAttachment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailAttachment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailAttachment->id)]) ?>
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
