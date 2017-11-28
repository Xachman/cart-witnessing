<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailAttachments form large-9 medium-8 columns content">
    <?= $this->Form->create($emailAttachment) ?>
    <fieldset>
        <legend><?= __('Add Email Attachment') ?></legend>
        <?php
            echo $this->Form->input('email_id', ['options' => $emails]);
            echo $this->Form->input('name');
            echo $this->Form->input('url');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
