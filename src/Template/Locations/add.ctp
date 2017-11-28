<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="locations form large-9 medium-8 columns content">
    <?= $this->Form->create($location) ?>
    <fieldset>
        <legend><?= __('Add Location') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
            ?>
            <select name="day">
                <?php foreach($days as $key => $val) {
                    echo "<option value=\"$key\" >$val</option>";
                }?>
                
            </select>
        <?php
            echo $this->Form->input('start_time', ['empty' => true]);
            echo $this->Form->input('end_time', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
