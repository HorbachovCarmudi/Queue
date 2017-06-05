<?php

use Repository\QueueFile;
use Collection\Queue;
use Collection\AutoScalingGroup;
use Service\LoadBalancer;
use Service\ConfigReader;

require_once('vendor/autoload.php');
define('CONFIG_PATH', dirname(__FILE__) . '/app/config.ini');

$balancer = new LoadBalancer(
    new AutoScalingGroup(ConfigReader::get('scaled_group_max_size'))
);

$queue = new Queue(ConfigReader::get('queue_max_size'));
$repo = new QueueFile(ConfigReader::get('queue_storage_filename'));
$repo->get($queue);

for ($i=0; $i<$queue->count();) {
    $balancer->runMessage($queue->bottom());
    $queue->dequeue();
    $queue = $repo->put($queue);
}

echo "\n" . 'No messages found' . "\n";
