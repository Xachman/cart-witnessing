<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Outcomes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outcomes form large-9 medium-8 columns content">
    <?= $this->Form->create($outcome) ?>
    <fieldset>
        <legend><?= __('Add Outcome') ?></legend>
        <?php
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('books');
            echo $this->Form->control('magazines');
            echo $this->Form->control('brochures');
            echo $this->Form->control('tracts');
            echo $this->Form->control('contact_cards');
            echo $this->Form->control('videos');
            echo $this->Form->control('return_visits');
            echo $this->Form->control('bible_studies');
            echo $this->Form->control('date_worked', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
