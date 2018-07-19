<?php

use Service\Producer;
use Repository\QueueFile;
use Collection\Queue;
use Entity\Message;
use Service\ConfigReader;
use Service\DependencyContainer;

require_once('vendor/autoload.php');
define('CONFIG_PATH', dirname(__FILE__) . '/app/config.ini');

$messagesToAdd = $argv[1] ?? 0;
if ($messagesToAdd < 1) {
    throw new Exception('Not specified number of messages to generate');
}

$producer = new Producer(
    new QueueFile(
        ConfigReader::get('queue_storage_filename'),
        new DependencyContainer()
    ),
    new Queue(
        ConfigReader::get('queue_max_size')
    )
);

$messages = [];
for ($i=0; $i<$messagesToAdd; $i++) {
    $messages[] = new Message(time() . '-' . $i, rand(1,10));
}
$producer->publishMessages($messages);

echo "\n" . $messagesToAdd . ' Messages published to Queue' . "\n";

