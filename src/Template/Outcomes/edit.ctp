<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $outcome->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $outcome->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Outcomes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outcomes form large-9 medium-8 columns content">
    <?= $this->Form->create($outcome) ?>
    <fieldset>
        <legend><?= __('Edit Outcome') ?></legend>
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
