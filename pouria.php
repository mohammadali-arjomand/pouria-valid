<?php

const REQUIRED = "required";
const MINIMUM = "min=";
const MAXIMUM = "max=";

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
                }
            }
        }
        return true;
    }
}