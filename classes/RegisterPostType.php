<?php
namespace mcd;
use \YcdCountdownOptionsConfig;

class RegisterPostType {

    private $typeObj;
    private $type;
    private $id;

    public function __construct() {
        $this->init();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return (int)$this->id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setTypeObj($typeObj) {
        $this->typeObj = $typeObj;
    }

    public function getTypeObj() {
        return $this->typeObj;
    }

    public function init() {

        $postType = MCD_COUNTDOWN_POST_TYPE;
        $args = $this->getPostTypeArgs();

        register_post_type($postType, $args);

        if(@$_GET['post_type'] || get_post_type(@$_GET['post']) == MCD_COUNTDOWN_POST_TYPE) {
            $this->createCdObjFromCdType();
        }
        YcdCountdownOptionsConfig::optionsValues();
    }

    private function createCdObjFromCdType() {
        $id = 0;

        if (!empty($_GET['post'])) {
            $id = (int)$_GET['post'];
        }

        $type = $this->getTypeName();
        $this->setType($type);
        $this->setId($id);

        $this->createCdObj();
    }

    public function createCdObj()
    {
        $id = $this->getId();
        $type = $this->getType();
        $typePath = Countdown::getTypePathFormCountdownType($type);
        $className = Countdown::getClassNameCountdownType($type);

        if (!file_exists($typePath.$className.'.php')) {
            wp_die(__('Countdown class does not exist', MCD_TEXT_DOMAIN));
        }
        require_once($typePath.$className.'.php');
        $className = __NAMESPACE__.'\\'.$className;
        $typeObj = new $className();
        $typeObj->setId($id);
        $this->setTypeObj($typeObj);
    }

    private function getTypeName() {
        $type = 'circle';

        /*
         * First, we try to find the countdown type with the post id then,
         * if the post id doesn't exist, we try to find it with $_GET['MCD_type']
         */
        if (!empty($_GET['post'])) {
            $id = (int)$_GET['post'];
            $cdOptionsData = Countdown::getPostSavedData($id);
            if (!empty($cdOptionsData['ycd-type'])) {
                $type = $cdOptionsData['ycd-type'];
            }
        }
        else if (!empty($_GET['MCD_type'])) {
            $type = $_GET['MCD_type'];
        }

        return $type;
    }

    public function getPostTypeArgs()
    {
        $labels = $this->getPostTypeLabels();

        $args = array(
            'labels'             => $labels,
            'description'        => __('Description.', 'your-plugin-textdomain'),
            //Exclude_from_search
            'public'             => true,
            //Where to show the post type in the admin menu
            'show_ui'            => true,
            'query_var'          => false,
            'capability_type'    => 'post',
            'menu_position'      => 10,
            'supports'           => apply_filters('ycdPostTypeSupport', array('title')),
            'menu_icon'          => 'dashicons-clock'
        );

        return $args;
    }

    public function getPostTypeLabels()
    {
        $labels = array(
            'name'               => _x('Countdowns', 'post type general name', MCD_TEXT_DOMAIN),
            'singular_name'      => _x('Countdown', 'post type singular name', MCD_TEXT_DOMAIN),
            'menu_name'          => _x('Countdowns', 'admin menu', MCD_TEXT_DOMAIN),
            'name_admin_bar'     => _x('Countdown', 'add new on admin bar', MCD_TEXT_DOMAIN),
            'add_new'            => _x('Add New', 'Countdown', MCD_TEXT_DOMAIN),
            'add_new_item'       => __('Add New Countdown', MCD_TEXT_DOMAIN),
            'new_item'           => __('New Countdown', MCD_TEXT_DOMAIN),
            'edit_item'          => __('Edit Countdown', MCD_TEXT_DOMAIN),
            'view_item'          => __('View Countdown', MCD_TEXT_DOMAIN),
            'all_items'          => __('All Countdowns', MCD_TEXT_DOMAIN),
            'search_items'       => __('Search Countdowns', MCD_TEXT_DOMAIN),
            'parent_item_colon'  => __('Parent Countdowns:', MCD_TEXT_DOMAIN),
            'not_found'          => __('No countdown found.', MCD_TEXT_DOMAIN),
            'not_found_in_trash' => __('No countdowns found in Trash.', MCD_TEXT_DOMAIN)
        );

        return $labels;
    }

    public function addSubMenu() {
        add_submenu_page('edit.php?post_type='.MCD_COUNTDOWN_POST_TYPE, __('Countdown Types', MCD_TEXT_DOMAIN), __('Countdown Types', MCD_TEXT_DOMAIN), 'manage_options', MCD_COUNTDOWN_POST_TYPE, array($this, 'countdownTypes'));
    }

    public function countdownTypes() {
        require_once MCD_VIEWS_PATH.'types.php';
    }
}