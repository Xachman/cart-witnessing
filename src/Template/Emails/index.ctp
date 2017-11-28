<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Email'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['controller' => 'EmailAttachments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['controller' => 'EmailAttachments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emails index large-9 medium-8 columns content">
    <h3><?= __('Emails') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emails as $email): ?>
            <tr>
                <td><?= $this->Number->format($email->id) ?></td>
                <td><?= h($email->subject) ?></td>
                <td><?= h($email->created) ?></td>
                <td><?= h($email->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $email->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $email->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id)]) ?>
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
