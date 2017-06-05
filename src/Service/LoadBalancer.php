<?php

namespace Service;

use Collection\AutoScalingGroup;
use Entity\Consumer;
use Entity\Message;
use Collection\Queue;
use Repository\QueueFile;
use Logger;

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
     * @var Queue
     */
    private $queue;

    /**
     * LoadBalancer constructor.
     * @param AutoScalingGroup $group
     * @param Queue $queue
     */
    public function __construct(AutoScalingGroup $group, Queue $queue)
    {
        $this->instanceGroup = $group;
        $this->queue = $queue;
    }

    /**
     * @param QueueFile $queueFile
     */
    public function proceedQueue(QueueFile $queueFile)
    {
        $queueFile->get($this->queue);
        $this->logState();

        while ($this->queue->count()) {
            $this->runMessage($this->queue->bottom());
            $this->queue = $queueFile->dequeue($this->queue);
        }

        $this->instanceGroup->flush();
    }

    private function logState()
    {
        Logger::getLogger("output")->info(
            'Queue size: ' . $this->queue->count()
            . ' | Instances running: ' . $this->instanceGroup->getCount()
        );
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
        $this->logState();
        sleep(1);
    }

    /**
     * @param Message $message
     * @param Consumer $consumer
     */
    private function simulateSubmit(Message $message, Consumer $consumer)
    {
        $consumer->proceed($message);
    }
}