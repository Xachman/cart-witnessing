<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Email Attachments'), ['controller' => 'EmailAttachments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email Attachment'), ['controller' => 'EmailAttachments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emails form large-9 medium-8 columns content">
    <?= $this->Form->create($email) ?>
    <fieldset>
        <legend><?= __('Send Email') ?></legend>
        <?php
            echo $this->Form->input('date', [
                'type'=>'date',
                'label' => 'Schedule Date',
                'selected' => time(),
                'minYear' => date('Y'),
                'maxYear' => date('Y') + 10,
                'day' => false
            ]);
            echo $this->Form->input('participant', [
                'type'=>'select',
                'label' => 'Schedule Date',
                'options' => $participants,
                'empty'=> true
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
