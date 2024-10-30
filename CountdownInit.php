<?php
namespace mcd;

class CountdownInit {

    private static $instance = null;
    private $actions;
    private $filters;

    private function __construct() {
        $this->init();
    }

    private function __clone() {

    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init() {
        $this->includeData();
        $this->actions();
        $this->filters();
    }

    private function includeData() {
        require_once MCD_HELPERS_PATH.'ScriptsIncluder.php';
        require_once MCD_HELPERS_PATH.'AdminHelper.php';
        require_once MCD_CLASSES_PATH.'CountdownType.php';
        require_once MCD_COUNTDOWNS_PATH.'Countdown.php';
        require_once MCD_CSS_PATH.'Css.php';
        require_once MCD_CLASSES_PATH.'RegisterPostType.php';
        require_once MCD_CLASSES_PATH.'Filters.php';
        require_once MCD_CLASSES_PATH.'Actions.php';
    }

    public function actions() {
        $this->actions = new Actions();
    }

    public function filters() {
        $this->filters = new Filters();
    }
}

CountdownInit::getInstance();