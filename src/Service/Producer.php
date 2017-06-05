<?php

namespace Service;

use Collection\Queue;
use Entity\Message;
use Repository\QueueFileRepository;

/**
 * Class Producer
 * @package Service
 */
final class Producer
{
    /**
     * @var QueueFileRepository
     */
    private $storage;

    /**
     * @var Queue
     */
    private $queue;

    /**
     * Producer constructor.
     * @param QueueFileRepository $storage
     * @param Queue $queue
     */
    public function __construct(QueueFileRepository $storage, Queue $queue)
    {
        $this->storage = $storage;
        $this->queue = $queue;
    }

    /**
     * @param Message $message
     */
    public function publishMessage(Message $message)
    {
        $this->storage->get($this->queue);
        $this->queue->enqueue($message);
        $this->storage->put($this->queue);
    }

    /**
     * @param array $messages
     */
    public function publishMessages(array $messages)
    {
        $this->storage->get($this->queue);
        foreach ($messages as $message) {
            $this->queue->enqueue($message);
        }
        $this->storage->put($this->queue);
    }
}