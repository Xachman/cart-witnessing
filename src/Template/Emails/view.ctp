<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email'), ['action' => 'edit', $email->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email'), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Emails'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['controller' => 'EmailAttachments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['controller' => 'EmailAttachments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emails view large-9 medium-8 columns content">
    <h3><?= h($email->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($email->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($email->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($email->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($email->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($email->message)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Email Attachments') ?></h4>
        <?php if (!empty($email->email_attachments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($email->email_attachments as $emailAttachments): ?>
            <tr>
                <td><?= h($emailAttachments->id) ?></td>
                <td><?= h($emailAttachments->email_id) ?></td>
                <td><?= h($emailAttachments->name) ?></td>
                <td><?= h($emailAttachments->url) ?></td>
                <td><?= h($emailAttachments->created) ?></td>
                <td><?= h($emailAttachments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmailAttachments', 'action' => 'view', $emailAttachments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailAttachments', 'action' => 'edit', $emailAttachments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailAttachments', 'action' => 'delete', $emailAttachments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailAttachments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
