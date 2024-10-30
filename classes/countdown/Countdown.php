<?php
namespace mcd;
use \YcdCountdownOptionsConfig;

abstract class Countdown {

    private $id;
    private $type;
    private $savedData;
    private $sanitizedData;

    abstract protected function getViewContent();

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

    public function setSavedData($savedData) {
        $this->savedData = $savedData;
    }

    public function getSavedData() {
        return $this->savedData;
    }

    public function insertIntoSanitizedData($sanitizedData) {
        if (!empty($sanitizedData)) {
            $this->sanitizedData[$sanitizedData['name']] = $sanitizedData['value'];
        }
    }

    public function getSanitizedData() {
        return $this->sanitizedData;
    }

    public static function create($data = array()) {
        $obj = new static();
        $id = $data['ycd-post-id'];
        $obj->setId($id);

        // set up applay filter
        YcdCountdownOptionsConfig::optionsValues();
        foreach ($data as $name => $value) {
            $defaultData = $obj->getDefaultDataByName($name);
            if (empty($defaultData['type'])) {
                $defaultData['type'] = 'string';
            }
            $sanitizedValue = $obj->sanitizeValueByType($value, $defaultData['type']);
            $obj->insertIntoSanitizedData(array('name' => $name,'value' => $sanitizedValue));
        }

        $result = $obj->save();
    }

    public function save() {
        $options = $this->getSanitizedData();
        $postId = $this->getId();

        update_post_meta($postId, 'MCD_options', $options);
    }

    public function sanitizeValueByType($value, $type) {
        switch ($type) {
            case 'string':
                $sanitizedValue = sanitize_text_field($value);
                break;
            case 'array':
                $sanitizedValue = $this->recursiveSanitizeTextField($value);
                break;
            case 'email':
                $sanitizedValue = sanitize_email($value);
                break;
            case "checkbox":
                $sanitizedValue = sanitize_text_field($value);
                break;
            default:
                $sanitizedValue = sanitize_text_field($value);
                break;
        }

        return $sanitizedValue;
    }

    public function recursiveSanitizeTextField($array) {
        if (!is_array($array)) {
            return $array;
        }

        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->recursiveSanitizeTextField($value);
            }
            else {
                /*get simple field type and do sanitization*/
                $defaultData = $this->getDefaultDataByName($key);
                if (empty($defaultData['type'])) {
                    $defaultData['type'] = 'string';
                }
                $value = $this->sanitizeValueByType($value, $defaultData['type']);
            }
        }

        return $array;
    }

    public function getDefaultDataByName($optionName) {
        global $MCD_OPTIONS;

        foreach ($MCD_OPTIONS as $option) {
            if ($option['name'] == $optionName) {
                return $option;
            }
        }

        return array();
    }

    public static function parseCountdownDataFromData($data) {
        $cdData = array();

        foreach ($data as $key => $value) {
            if (strpos($key, 'ycd') === 0) {
                $cdData[$key] = $value;
            }
        }

        return $cdData;
    }

    public static function getClassNameCountdownType($type) {
        $typeName = ucfirst(strtolower($type));
        $className = $typeName.'Countdown';

        return $className;
    }

    public static function getTypePathFormCountdownType($type) {
        global $MCD_TYPES;
        $typePath = '';

        if (!empty($MCD_TYPES['typePath'][$type])) {
            $typePath = $MCD_TYPES['typePath'][$type];
        }

        return $typePath;
    }

    /**
     * Get option value from name
     * @since 1.0.0
     *
     * @param string $optionName
     * @param bool $forceDefaultValue
     * @return srting
     */
    public function getOptionValue($optionName, $forceDefaultValue = false) {
        require_once(dirname(__FILE__).'/CountdownModel.php');
        $savedData = CountdownModel::getDataById($this->getId());
        $this->setSavedData($savedData);

        return $this->getOptionValueFromSavedData($optionName, $forceDefaultValue);
    }

    public function getOptionValueFromSavedData($optionName, $forceDefaultValue = false) {
        $defaultData = $this->getDefaultDataByName($optionName);
        $savedData = $this->getSavedData();

        $optionValue = null;

        if (empty($defaultData['type'])) {
            $defaultData['type'] = 'string';
        }

        if (!empty($savedData)) { //edit mode
            if (isset($savedData[$optionName])) { //option exists in the database
                $optionValue = $savedData[$optionName];
            }
            /* if it's a checkbox, it may not exist in the db
             * if we don't care about it's existance, return empty string
             * otherwise, go for it's default value
             */
            else if ($defaultData['type'] == 'checkbox' && !$forceDefaultValue) {
                $optionValue = '';
            }
        }

        if ($optionValue === null && !empty($defaultData['defaultValue'])) {
            $optionValue = $defaultData['defaultValue'];
        }

        if ($defaultData['type'] == 'checkbox') {
            $optionValue = $this->boolToChecked($optionValue);
        }

        return $optionValue;
    }

    public static function getPostSavedData($postId) {
        $savedData = get_post_meta($postId, 'MCD_options');
        $savedData = $savedData[0];

        return $savedData;
    }

    /**
     * Returns separate countdown types Free or Pro
     *
     * @since 1.0.0
     *
     * @return array $countdownType
     */
    public static function getCountdownTypes() {
        global $MCD_TYPES;
        $countdownTypesObj = array();
        $countdownTypes = $MCD_TYPES['typeName'];

        foreach($countdownTypes as $type => $level) {
            if(empty($level)) {
                $level = MCD_FREE_VERSION;
            }
            $typeObj = new CountdownType();
            $typeObj->setName($type);
            $typeObj->setAccessLevel($level);

            if(MCD_PKG_VERSION >= $level) {
                $typeObj->setAvailable(true);
            }
            $countdownTypesObj[] = $typeObj;
        }

        return $countdownTypesObj;
    }

    public function boolToChecked($var) {
        return ($var ? 'checked' : '');
    }
}