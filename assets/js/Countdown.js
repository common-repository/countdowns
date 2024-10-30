function YcdCountdown() {
    this.init();
}

YcdCountdown.prototype.init = function() {
    jQuery('#DateCountdown').TimeCircles();
    this.initCountdownDateTimePicker();
};

YcdCountdown.prototype.initCountdownDateTimePicker = function() {
    var countdown = jQuery('#ycd-date-time-picker');

    if(!countdown.length) {
        return false;
    }

    countdown.datetimepicker({
        format: 'Y-m-d H:i',
        minDate: 0
    });
};

jQuery(document).ready(function () {
    new YcdCountdown();
});