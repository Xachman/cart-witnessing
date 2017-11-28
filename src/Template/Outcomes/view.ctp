<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Outcome'), ['action' => 'edit', $outcome->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Outcome'), ['action' => 'delete', $outcome->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outcome->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Outcomes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Outcome'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="outcomes view large-9 medium-8 columns content">
    <h3><?= h($outcome->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $outcome->has('location') ? $this->Html->link($outcome->location->name, ['controller' => 'Locations', 'action' => 'view', $outcome->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($outcome->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Books') ?></th>
            <td><?= $this->Number->format($outcome->books) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Magazines') ?></th>
            <td><?= $this->Number->format($outcome->magazines) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brochures') ?></th>
            <td><?= $this->Number->format($outcome->brochures) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tracts') ?></th>
            <td><?= $this->Number->format($outcome->tracts) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contact Cards') ?></th>
            <td><?= $this->Number->format($outcome->contact_cards) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Videos') ?></th>
            <td><?= $this->Number->format($outcome->videos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Return Visits') ?></th>
            <td><?= $this->Number->format($outcome->return_visits) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bible Studies') ?></th>
            <td><?= $this->Number->format($outcome->bible_studies) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Worked') ?></th>
            <td><?= h($outcome->date_worked) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($outcome->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($outcome->modified) ?></td>
        </tr>
    </table>
</div>
