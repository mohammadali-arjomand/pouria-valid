# Pouria Valid
![Pouria vali](https://s29.picofile.com/file/8466457818/poura_valid.jpg)
Cartoon image from Pouria vali, an iranian hero &uarr;&uarr;&uarr;

# Introduction
Pouria valid is a lightweight, easy-to-use and powerful library for data validation in PHP

# Example
```php
<?php

require "src/pouria.php";

$pouria = new Pouria($_REQUEST);
$pouria->conditions([
    "name" => [
        REQUIRED,
        MINIMUM . 5,
        MAXIMUM . 16
    ]
]);

echo $pouria->check ? "Data is valid" : "Data is invalid";
```

# Installation
You can install PouriaValid via ...
## Composer
```bash
composer require arjomand/pouria-valid
```
## Git
```bash
git clone https://github.com/mohammadali-arjomand/pouria-valid.git
```
## Local
[Download latest release](https://github.com/mohammadali-arjomand/pouria-valid/archive/refs/tags/v1.1.1.zip)

# Documentation
For see documentation click [here](https://github.com/mohammadali-arjomand/pouria-valid/wiki)

# License
MIT License, Copyright (c) 2023 MohammadAli Arjomand
