<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['controller' => 'EmailAttachments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['controller' => 'EmailAttachments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emails form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Send Email') ?></legend>
        <?php
            echo $this->Form->control('to_email', [
                'type'=>'text',
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
