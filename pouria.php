<?php

const REQUIRED = "required";
const MINIMUM = "min=";
const MAXIMUM = "max=";
const JUST = "just=";

class Pouria {
    public static function valid($check, $conditions) {
        foreach ($conditions as $name => $conditions_list) {
            foreach ($conditions_list as $condition) {
                $exploded_condition = explode("=", $condition);
                switch ($exploded_condition[0]) {
                    case "required": {
                        if (!isset($check[$name]) || is_null($check[$name]) || empty($check[$name])) {
                            return false;
                        }
                        break;
                    }
                    case "min": {
                        if (strlen($check[$name]) < $exploded_condition[1]) {
                            return false;
                        }
                        break;
                    }
                    case "max": {
                        if (strlen($check[$name]) > $exploded_condition[1]) {
                            return false;
                        }
                        break;
                    }
                    case "just": {
                        $characters = str_split($exploded_condition[1], 1);
                        $value = $check[$name];
                        foreach ($characters as $character) {
                            $value = str_replace($character, "", $value);
                        }
                        if (!empty($value)) {
                            return false;
                        }
                        break;
                    }
                }
            }
        }
        return true;
    }
}