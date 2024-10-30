<?php
namespace mcd;

class Css {

    public function __construct() {
        $this->init();
    }

    public function init() {

        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
    }

    public function enqueueStyles($hook) {

        ScriptsIncluder::registerStyle('admin.css');
        ScriptsIncluder::registerStyle('bootstrap.css');

        if($hook == 'ycdcountdown_page_ycdcountdown' || @$_GET['post_type'] == MCD_COUNTDOWN_POST_TYPE) {
            ScriptsIncluder::enqueueStyle('bootstrap.css');
            ScriptsIncluder::enqueueStyle('admin.css');
        }
    }
}

new Css();