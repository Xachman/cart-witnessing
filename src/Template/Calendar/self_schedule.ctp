<?php if (isset($participant)) { ?>

<div class="content">
    <div><?=$participant->first_name?> <?=$participant->last_name?></div>
    <?=$this->Calendar->displayFullCalendar(); ?>
</div>
<?php
}else{
    ?>
<div class="users form columns medium-offset-3 medium-6">
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email') ?></legend>
        <?= $this->Form->control('email') ?>
    </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>
    <?php
}
