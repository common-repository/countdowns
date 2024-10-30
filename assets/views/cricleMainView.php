<?php
$dueDate = $typeObj->getOptionValue('ycd-date-time-picker');
$type = @$typeObj->getOptionValue('mcd-type');
if(empty($type)) {
    $type = @$_GET['mcd_type'];
}
?>
<div class="ycd-bootstrap-wrapper">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <label><?php _e('Due date', MCD_TEXT_DOMAIN); ?></label>
                </div>
                <div class="col-md-7">
                    <input type="text" id="ycd-date-time-picker" class="form-control" name="ycd-date-time-picker" value="<?php echo esc_attr($dueDate); ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>

<input type="hidden" name="mcd-type" value="<?php echo esc_attr($type); ?>">