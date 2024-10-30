<?php

class YcdCountdownConfig {
    public static function addDefine($name, $value) {
        if(!defined($name)) {
            define($name, $value);
        }
    }

    public static function init() {
        self::addDefine('MCD_ADMIN_URL', admin_url());
        self::addDefine('MCD_COUNTDOWN_BUILDER_URL', plugins_url().'/'.MCD_FOLDER_NAME.'/');
        self::addDefine('MCD_COUNTDOWN_ADMIN_URL', admin_url());
        self::addDefine('MCD_COUNTDOWN_URL', plugins_url().'/'.MCD_FOLDER_NAME.'/');
        self::addDefine('MCD_COUNTDOWN_ASSETS_URL', MCD_COUNTDOWN_URL.'assets/');
        self::addDefine('MCD_COUNTDOWN_CSS_URL', MCD_COUNTDOWN_ASSETS_URL.'css/');
        self::addDefine('MCD_COUNTDOWN_JS_URL', MCD_COUNTDOWN_ASSETS_URL.'js/');
        self::addDefine('MCD_COUNTDOWN_PATH', WP_PLUGIN_DIR.'/'.MCD_FOLDER_NAME.'/');
        self::addDefine('MCD_CLASSES_PATH', MCD_COUNTDOWN_PATH.'classes/');
        self::addDefine('MCD_HELPERS_PATH', MCD_COUNTDOWN_PATH.'helpers/');
        self::addDefine('MCD_ASSETS_PATH', MCD_COUNTDOWN_PATH.'/assets/');
        self::addDefine('MCD_VIEWS_PATH', MCD_ASSETS_PATH.'views/');
        self::addDefine('MCD_CSS_PATH', MCD_ASSETS_PATH.'css/');
        self::addDefine('MCD_COUNTDOWNS_PATH', MCD_CLASSES_PATH.'countdown/');
        self::addDefine('MCD_HELPERS_PATH', MCD_COUNTDOWN_PATH.'helpers/');
        self::addDefine('MCD_COUNTDOWN_POST_TYPE', 'mcdcountdown');
        self::addDefine('MCD_TEXT_DOMAIN', 'mcdCountdown');
        self::addDefine('MCD_VERSION', 1.0);
        self::addDefine('MCD_FREE_VERSION', 1);
        self::addDefine('MCD_SILVER_VERSION', 2);
        self::addDefine('MCD_GOLD_VERSION', 3);
        self::addDefine('MCD_PKG_VERSION', 3);
    }
}

YcdCountdownConfig::init();
