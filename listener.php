<?php

use Repository\QueueFile;
use Collection\Queue;
use Collection\AutoScalingGroup;
use Service\LoadBalancer;
use Service\ConfigReader;

require_once('vendor/autoload.php');
define('CONFIG_PATH', dirname(__FILE__) . '/app/config.ini');

Logger::configure(ConfigReader::get('log_config'));

$balancer = new LoadBalancer(
    new AutoScalingGroup(ConfigReader::get('scaled_group_max_size')),
    new Queue(ConfigReader::get('queue_max_size'))
);

$repo = new QueueFile(ConfigReader::get('queue_storage_filename'));

$simulateRunning = true;
while ($simulateRunning) {
    $balancer->proceedQueue($repo);
    sleep('1');
}
