<?php
namespace mcd;

class CountdownModel {
    private static $data = array();

    private function __construct() {
    }

    public static function getDataById($postId) {
        if (!isset(self::$data[$postId])) {
            self::$data[$postId] = Countdown::getPostSavedData($postId);
        }

        return self::$data[$postId];
    }
}