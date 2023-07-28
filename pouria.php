<?php

const REQUIRED = "required";
const MINIMUM = "min=";
const MAXIMUM = "max=";
const JUST = "just=";
const NOCHAR = "nochar=";
const COUNT = "count=";
const START = "start=";
const END = "end=";
const REGEX = "regex=";
const EMAIL = "email";
const PHONE = "phone";
const NUMBER = "number";
const HAS = "has=";
const HASCHAR = "haschar=";

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
                    case "count": {
                        if (strlen($this->request[$name]) != $exploded_condition[1]) {
                            $this->check = false;
                            $message = isset($this->custom_messages->count)
                                ? $this->custom_messages->count
                                : ":key field must contains :value characters (no more, no less)";
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
                    case "nochar": {
                        $characters = str_split($exploded_condition[1], 1);
                        foreach ($characters as $character) {
                            if (strstr($this->request[$name], $character)) {
                                $this->check = false;
                                $message = isset($this->custom_messages->nochar)
                                    ? $this->custom_messages->nochar
                                    : "in :key field you cannot use :value character(s)";
                                $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                                $message = str_replace(":value", join(" ", $characters), $message);
                                $this->messages[] = $message;
                            }
                        }
                        break;
                    }
                    case "start": {
                        if (substr($this->request[$name], 0, strlen($exploded_condition[1])) != $exploded_condition[1]) {
                            $this->check = false;
                            $message = isset($this->custom_messages->start)
                                ? $this->custom_messages->start
                                : ":key field must start with :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "end": {
                        if (substr($this->request[$name], strlen($this->request[$name])-strlen($exploded_condition[1]), strlen($this->request[$name])) != $exploded_condition[1]) {
                            $this->check = false;
                            $message = isset($this->custom_messages->end)
                                ? $this->custom_messages->end
                                : ":key field must end with :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "regex": {
                        if (!preg_match($exploded_condition[1], $this->request[$name])) {
                            $this->check = false;
                            $message = isset($this->custom_messages->regex)
                                ? $this->custom_messages->regex
                                : ":key field must follow rule";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "email": {
                        if (!filter_var($this->request[$name], FILTER_VALIDATE_EMAIL)) {
                            $this->check = false;
                            $message = isset($this->custom_messages->email)
                                ? $this->custom_messages->email
                                : ":key field is not a valid email";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "phone": {
                        if (!preg_match("/^[0-9]{10}$/", $this->request[$name])) {
                            $this->check = false;
                            $message = isset($this->custom_messages->phone)
                                ? $this->custom_messages->phone
                                : ":key field is not a valid phone";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "number": {
                        if (!is_numeric($this->request[$name])) {
                            $this->check = false;
                            $message = isset($this->custom_messages->number)
                                ? $this->custom_messages->number
                                : ":key field is not number";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $this->messages[] = $message;
                        }
                        break;
                    }
                    case "has": {
                        if (!strstr($this->request[$name], $exploded_condition[1])) {
                            $this->check = false;
                            $message = isset($this->custom_messages->has)
                                ? $this->custom_messages->has
                                : ":key field must contains :value";
                            $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                            $message = str_replace(":value", $exploded_condition[1], $message);
                            $this->messages[] = $message;
                        }
                    }
                    case "haschar": {
                        $characters = str_split($exploded_condition[1], 1);
                        foreach ($characters as $character) {
                            if (!strstr($this->request[$name], $character)) {
                                $this->check = false;
                                $message = isset($this->custom_messages->haschar)
                                    ? $this->custom_messages->haschar
                                    : "in :key field you must use :value character(s)";
                                $message = str_replace(":key", isset($this->labels[$name]) ? $this->labels[$name] : $name, $message);
                                $message = str_replace(":value", join(" ", $characters), $message);
                                $this->messages[] = $message;
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }
    }
}