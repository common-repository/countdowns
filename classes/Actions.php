<?php
namespace mcd;

class Actions {
    public $customPostTypeObj;

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_action('init', array($this, 'postTypeInit'));
        add_action('admin_menu', array($this, 'addSubMenu'));
        add_action('save_post', array($this, 'savePost'), 10, 3);
        add_shortcode('MCD_countdown', array($this, 'shortcode'));
        add_action('manage_'.MCD_COUNTDOWN_POST_TYPE.'_posts_custom_column' , array($this, 'tableColumnValues'), 10, 2);
    }

    public function postTypeInit() {
        $this->customPostTypeObj = new RegisterPostType();
    }

    public function addSubMenu()
    {
        $this->customPostTypeObj->addSubMenu();
    }

    public function savePost($postId, $post, $update) {

        if(!$update) {
            return false;
        }
        $postData = Countdown::parseCountdownDataFromData($_POST);
        if(empty($postData)) {
            return false;
        }
        $postData['ycd-post-id'] = $postId;

        if (!empty($postData['ycd-type'])) {
            $type = $postData['ycd-type'];
            $typePath = Countdown::getTypePathFormCountdownType($type);
            $className = Countdown::getClassNameCountdownType($type);

            require_once($typePath.$className.'.php');
            $className = __NAMESPACE__.'\\'.$className;

            $className::create($postData);
        }
    }

    public function shortcode($args, $content) {
        $id = $args['id'];
        $type = 'circle';

        if (!empty($cdOptionsData['ycd-type'])) {
            $type = $cdOptionsData['ycd-type'];
        }

        $typePath = Countdown::getTypePathFormCountdownType($type);
        $className = Countdown::getClassNameCountdownType($type);

        if (!file_exists($typePath.$className.'.php')) {
            return '';
        }

        require_once($typePath.$className.'.php');
        $className = __NAMESPACE__.'\\'.$className;
        $typeObj = new $className();
        $typeObj->setId($id);

        return $typeObj->getViewContent();
    }

    public function tableColumnValues($column, $postId) {
        if ($column == 'shortcode') {
            echo '<input type="text" onfocus="this.select();" readonly value="[MCD_countdown id='.$postId.']" class="large-text code">';
        }
    }
}