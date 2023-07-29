# Pouria Valid
![Pouria vali](https://s29.picofile.com/file/8466457818/poura_valid.jpg)
Cartoon image from Pouria vali, an iranian hero &uarr;&uarr;&uarr;

# Introduction
Pouria valid is a lightweight, easy-to-use and powerful library for data validation in PHP

# Example
It's a example from Pouria valid
```php
<?php

use Arjomand\PouriaValid\Pouria;

$pouria = new Pouria($_REQUEST);
$pouria->conditions([
    "name" => [
        "required",
        "min=5",
        "max=16"
    ]
]);

echo $pouria->check ? "Data is valid" : "Data is invalid";
```

# Installation
You can install Pouria valid via composer by this command
```bash
composer require arjomand/pouria-valid
```
# Documentation
For see documentation click [here](https://github.com/mohammadali-arjomand/pouria-valid/wiki)

# License
MIT License, Copyright (c) 2023 MohammadAli Arjomand
