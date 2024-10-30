<?php
use mcd\Countdown;
use mcd\AdminHelper;
$types = Countdown::getCountdownTypes();
?>
<div class="ycd-bootstrap-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h3><?php _e('Add New Countdown', MCD_TEXT_DOMAIN); ?></h3>
        </div>
    </div>
    <?php foreach ($types as $type): var_dump(AdminHelper::buildCreateCountdownUrl($type)); ?>
        <a class="create-countdown-link" href="<?php echo AdminHelper::buildCreateCountdownUrl($type); ?>">
            <div class="countdowns-div <?php echo AdminHelper::getCountdownThumbClass($type); ?>"></div>
        </a>
    <?php endforeach; ?>
</div>