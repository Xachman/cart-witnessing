<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="participants form large-9 medium-8 columns content">
    <?= $this->Form->create($participant) ?>
    <fieldset>
        <legend><?= __('Edit Participant') ?></legend>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name'); ?>
        <label for="title">Title</label>
        <select name="title">
            <option>--Select--</option>
                <?php
                $titleValues = array("Brother", "Sister");
                foreach($titleValues as $value) {
                    echo "<option value=\"$value\" ".(($value == $participant->title)? "selected=\"selected\"" : "" ).">$value</option>";
                }?>
        </select>
            <?php
            echo $this->Form->control('email');
            echo $this->Form->control('phone');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
