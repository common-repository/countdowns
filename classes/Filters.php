<?php
namespace mcd;

class Filters {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_filter('admin_url', array($this, 'addNewPostUrl'), 10, 2);
        add_filter('manage_'.MCD_COUNTDOWN_POST_TYPE.'_posts_columns' , array($this, 'tableColumns'));
    }

    public function addNewPostUrl($url, $path)
    {
        if ($path == 'post-new.php?post_type='.MCD_COUNTDOWN_POST_TYPE) {
            $url = str_replace('post-new.php?post_type='.MCD_COUNTDOWN_POST_TYPE, 'edit.php?post_type='.MCD_COUNTDOWN_POST_TYPE.'&page='.MCD_COUNTDOWN_POST_TYPE, $url);
        }

        return $url;
    }

    public function tableColumns($columns) {
        unset($columns['date']);

        $additionalItems = array();
        $additionalItems['shortcode'] = __('Shortcode', MCD_TEXT_DOMAIN);

        return $columns + $additionalItems;
    }
}