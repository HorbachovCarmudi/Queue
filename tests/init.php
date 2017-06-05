<?php

use Service\ConfigReader;

define('CONFIG_PATH', dirname(dirname(__FILE__))  . '/app/config_test.ini');
require dirname(dirname(__FILE__)) . '/vendor/autoload.php';

Logger::configure(ConfigReader::get('log_config'));