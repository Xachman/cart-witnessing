<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Attachment'), ['action' => 'edit', $emailAttachment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Attachment'), ['action' => 'delete', $emailAttachment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailAttachment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailAttachments view large-9 medium-8 columns content">
    <h3><?= h($emailAttachment->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= $emailAttachment->has('email') ? $this->Html->link($emailAttachment->email->id, ['controller' => 'Emails', 'action' => 'view', $emailAttachment->email->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($emailAttachment->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailAttachment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($emailAttachment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($emailAttachment->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Url') ?></h4>
        <?= $this->Text->autoParagraph(h($emailAttachment->url)); ?>
    </div>
</div>
