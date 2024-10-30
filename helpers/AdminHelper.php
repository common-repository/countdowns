<?php
namespace mcd;


class AdminHelper {
    public static function buildCreateCountdownUrl($type) {
        $isAvailable = $type->isAvailable();
        $name = $type->getName();
  
        $url = MCD_COUNTDOWN_ADMIN_URL.'post-new.php?post_type='.MCD_COUNTDOWN_POST_TYPE.'&mcd_type='.$name;

        if (!$isAvailable) {
            $url = '';
        }

        return $url;
    }

    public static function getCountdownThumbClass($type) {
        $isAvailable = $type->isAvailable();
        $name = $type->getName();

        $typeClassName = $name.'-countdown';

        if (!$isAvailable) {
            $typeClassName .= '-pro';
        }

        return $typeClassName;
    }
}