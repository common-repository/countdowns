<?php

class YcdCountdownOptionsConfig {

    public static function init() {
        global $MCD_TYPES;

        $MCD_TYPES['typeName'] = apply_filters('ycdTypes', array(
            'circle' => MCD_FREE_VERSION
        ));

        $MCD_TYPES['typePath'] = apply_filters('ycdTypePaths', array(
            'circle' => MCD_COUNTDOWNS_PATH
        ));
    }

    public static function optionsValues() {
        global $MCD_OPTIONS;
        $options = array();

        $MCD_OPTIONS = apply_filters('ycdCountdownDefaultOptions', $options);;
    }
}

YcdCountdownOptionsConfig::init();