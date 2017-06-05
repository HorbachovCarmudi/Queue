<?php

namespace Service;

use Collection\AutoScalingGroup;
use Entity\Consumer;
use Entity\Message;
use Collection\Queue;
use Repository\QueueFile;

/**
 * Class LoadBalancer
 * @package Entity
 */
final class LoadBalancer
{
    /**
     * @var AutoScalingGroup
     */
    private $instanceGroup;

    /**
     * LoadBalancer constructor.
     * @param AutoScalingGroup $group
     */
    public function __construct(AutoScalingGroup $group)
    {
        $this->instanceGroup = $group;
    }

    /**
     * @param QueueFile $queueFile
     * @param Queue $queue
     */
    public function proceedQueue(QueueFile $queueFile, Queue $queue)
    {
        $queueFile->get($queue);

        while ($queue->count()) {
            $this->runMessage($queue->bottom());
            $queue = $queueFile->dequeue($queue);
        }

        $this->instanceGroup->flush();
    }

    /**
     * @param Message $message
     */
    private function runMessage(Message $message)
    {
        $consumer = $this->instanceGroup->getFreeConsumer();
        if (!$consumer) {
            $this->simulateWaiting($message);
            $this->runMessage($message);
        } else {
            $this->simulateSubmit($message, $consumer);
        }
    }

    /**
     * @param Message $message
     */
    private function simulateWaiting(Message $message)
    {
        echo ' - waiting for free instance with message: ' . $message->getId() . "\n";
        sleep(1);
    }

    /**
     * @param Message $message
     * @param Consumer $consumer
     */
    private function simulateSubmit(Message $message, Consumer $consumer)
    {
        echo 'Starting with message: ' . $message->getId() . ' on instance ' . $consumer->getId() . "\n";
        $consumer->proceed($message);
    }
}