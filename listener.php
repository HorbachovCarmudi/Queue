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

$simulateRunning = true;
while ($simulateRunning) {
    proceed($repo, $queue, $balancer);
    sleep('1');
}

function proceed(QueueFile $repo, Queue $queue, LoadBalancer $balancer) : int
{
    $count = 0;
    $repo->get($queue);

    while ($queue->count()) {
        $balancer->runMessage($queue->bottom());
        $count++;
        $queue = $repo->dequeue($queue);

        if (!$queue->count()) {
            echo 'Switching to waiting mode after finishing ' . $count . ' messages' . "\n";
        }
    }

    return $count;
}
