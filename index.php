<?php
require_once('vendor/autoload.php');

use Entity\Message;
use Collection\Queue;
use Service\LoadBalancer;
use Collection\AutoScalingGroup;
use Repository\QueueFileRepository;

$q = new Queue(7);
$repo = new QueueFileRepository('var/queue.csv');

$producer = new \Service\Producer($repo, $q);
$producer->publishMessage(new Message(21, 1));
$producer->publishMessage(new Message(22, 1));
$producer->publishMessage(new Message(23, 1));
$producer->publishMessage(new Message(24, 1));
$producer->publishMessage(new Message(25, 1));
$producer->publishMessage(new Message(26, 1));
/*
$q->enqueue(new Message(1, 1));
$q->enqueue(new Message(2,5));
$q->enqueue(new Message(3, 1));
$q->enqueue(new Message(4,1));
$q->enqueue(new Message(5,1));

$repo = new QueueFileRepository('var/queue.csv');
$repo->put($q);
var_dump($q);

$q = new Queue(3);
$repo->get($q);
var_dump($q);

exit('good');

$instanceGroup = new AutoScalingGroup(1);
$lb = new LoadBalancer($instanceGroup);

$queueSize = $q->count();
for ($i=0; $i<$queueSize; $i++) {
    $lb->runMessage($q->bottom());
    $q->dequeue();
}


echo "\n";
echo 'success';
echo "\n";
*/
