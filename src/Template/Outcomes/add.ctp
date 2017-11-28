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
            echo $this->Form->input('location_id', ['options' => $locations]);
            echo $this->Form->input('books');
            echo $this->Form->input('magazines');
            echo $this->Form->input('brochures');
            echo $this->Form->input('tracts');
            echo $this->Form->input('contact_cards');
            echo $this->Form->input('videos');
            echo $this->Form->input('return_visits');
            echo $this->Form->input('bible_studies');
            echo $this->Form->input('date_worked', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
