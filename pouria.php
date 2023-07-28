<?php

const REQUIRED = "required";
const MINIMUM = "min=";
const MAXIMUM = "max=";
const JUST = "just=";

class Pouria {
    public $check = true;
    public $messages = [];
    public $labels = [];
    public $custom_messages = null;
    public function __construct($request) {
        $this->request = $request;
    }
    public function messages($decoded_json) {
        $this->custom_messages = $decoded_json;
    }
    public function labels($labels) {
        $this->labels = $labels;
    }
    public function conditions($conditions) {
        foreach ($conditions as $name => $conditions_list) {
            foreach ($conditions_list as $condition) {
                $exploded_condition = explode("=", $condition);
                switch ($exploded_condition[0]) {
                    case "required": {
                        if (!isset($this->request[$name]) || is_null($this->request[$name]) || empty($this->request[$name])) {
                            $this->check = false;
                            $message = isset($this->custom_messages->required)
                                ? $this->custom_messages->required
                                : ":name field is required";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "min": {
                        if (strlen($this->request[$name]) < $exploded_condition[1]) {
                            $this->check = false;
                            $message = isset($this->custom_messages->min)
                                ? $this->custom_messages->min
                                : ":key field minimum characters count is :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "max": {
                        if (strlen($this->request[$name]) > $exploded_condition[1]) {
                            $this->check = false;
                            $message = isset($this->custom_messages->max)
                                ? $this->custom_messages->max
                                : ":key field maximum characters count is :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "just": {
                        $characters = str_split($exploded_condition[1], 1);
                        $value = $this->request[$name];
                        foreach ($characters as $character) {
                            $value = str_replace($character, "", $value);
                        }
                        if (!empty($value)) {
                            $this->check = false;
                            $message = isset($this->custom_messages->just)
                                ? $this->custom_messages->just
                                : ":key field only can contains :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", join(" ", $characters), $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                }
            }
        }
    }
}