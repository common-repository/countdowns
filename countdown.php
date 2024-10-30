<?php
/**
 * Plugin Name: Countdown
 * Description: WordPress countdown plugin by Mike.
 * Version: 1.0.0
 * Author: Mike Larson
 * Author URI:
 * License: GPLv2
 */

/*If this file is called directly, abort.*/
if(!defined('WPINC')) {
    wp_die();
}

if(!defined('MCD_FILE_NAME')) {
    define('MCD_FILE_NAME', plugin_basename(__FILE__));
}

if(!defined('MCD_FOLDER_NAME')) {
    define('MCD_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'config/boot.php');
require_once(plugin_dir_path(__FILE__).'CountdownInit.php');