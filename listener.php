<?php

use Repository\QueueFile;
use Collection\Queue;
use Collection\AutoScalingGroup;
use Service\LoadBalancer;
use Service\ConfigReader;
use Service\DependencyContainer;

require_once('vendor/autoload.php');
define('CONFIG_PATH', dirname(__FILE__) . '/app/config.ini');

Logger::configure(ConfigReader::get('log_config'));

$dependencyContainer = new DependencyContainer();

$balancer = new LoadBalancer(
    new AutoScalingGroup(ConfigReader::get('scaled_group_max_size'), $dependencyContainer),
    new Queue(ConfigReader::get('queue_max_size'))
);

$repo = new QueueFile(
    ConfigReader::get('queue_storage_filename'), $dependencyContainer
);

$simulateRunning = true;
while ($simulateRunning) {
    $balancer->proceedQueue($repo);
    sleep('1');
}
