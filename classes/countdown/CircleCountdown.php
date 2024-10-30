<?php
namespace mcd;

class CircleCountdown extends Countdown {

    public function __construct() {
        $this->includeStyles();
        add_action('add_meta_boxes', array($this, 'mainOptions'));
        add_filter('ycdCountdownDefaultOptions', array($this, 'defaultOptions'), 1, 1);
    }

    public function defaultOptions($options) {
        $options[] = array('name' => 'ycd-date-time-picker', 'type' => 'text', 'defaultValue' => date('Y-m-d H:i', strtotime(' +1 day')));

        return $options;
    }

    public function includeStyles() {
        ScriptsIncluder::registerScript('jquery.datetimepicker.full.min.js');
        ScriptsIncluder::enqueueScript('jquery.datetimepicker.full.min.js');
        ScriptsIncluder::registerScript('Countdown.js');
        ScriptsIncluder::enqueueScript('Countdown.js');
        ScriptsIncluder::registerScript('TimeCircles.js');
        ScriptsIncluder::enqueueScript('TimeCircles.js');
        ScriptsIncluder::registerStyle('jquery.dateTimePicker.min.css');
        ScriptsIncluder::enqueueStyle('jquery.dateTimePicker.min.css');
        ScriptsIncluder::registerStyle('TimeCircles.css');
        ScriptsIncluder::enqueueStyle('TimeCircles.css');
    }

    public function mainOptions(){

        add_meta_box('ycdMainOptions', __('Countdown options', MCD_TEXT_DOMAIN), array($this, 'mainView'), MCD_COUNTDOWN_POST_TYPE, 'normal', 'high');
    }

    public function mainView() {
        $typeObj = $this;
        require_once MCD_VIEWS_PATH.'cricleMainView.php';
    }

    public function getViewContent() {

        $dueDate = $this->getOptionValue('ycd-date-time-picker');
        $dueDate .= ':00';

        return '<div id="DateCountdown" data-date="'.$dueDate.'" style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF"></div>';
    }
}