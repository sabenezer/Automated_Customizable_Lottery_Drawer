<?php
error_reporting(0);
date_default_timezone_set('Africa/Nairobi');

define('APP_NAME', "Abay Lottery Draws");
define('APP_DIR', dirname(__DIR__));
define('LOG_FILE_PATH', APP_DIR . "/logs/.log");

include __DIR__ . '/../vendor/autoload.php';