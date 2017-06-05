<?php

namespace Repository;

use Collection\Queue;
use Entity\Message;
use Service\DependencyContainer;

/**
 * Class QueueFile
 * @package Repository
 */
class QueueFile
{
    /**
     * @var DependencyContainer
     */
    private $dependencyContainer;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var Resource|null
     */
    private $storage;

    /**
     * QueueFile constructor.
     * @param string $fileName
     * @param DependencyContainer $dependencyContainer
     */
    public function __construct(string $fileName, DependencyContainer $dependencyContainer)
    {
        $this->fileName = $fileName;
        $this->dependencyContainer = $dependencyContainer;
    }

    /**
     * @param Queue $queue
     * @return Queue
     */
    public function get(Queue $queue) : Queue
    {
        $this->startTransaction('rb');

        while ($row = fgetcsv($this->storage)) {
            $message = $this->dependencyContainer->getMessage([$row[0], $row[1]]);
            $queue->enqueue($message);
        }

        $this->finishTransaction();
        return $queue;
    }

    /**
     * @param Queue $queue
     */
    public function put(Queue $queue)
    {
        $queueSize = $queue->count();

        $this->startTransaction('wb');

        for ($i=0; $i<$queueSize; $i++) {
            /* @var $message Message*/
            $message = $queue->bottom();
            fputcsv(
                $this->storage,
                [
                    $message->getId(),
                    $message->getSecondsToExecute()
                ]
            );
            $queue->dequeue();
        }

        $this->finishTransaction();
    }

    /**
     * @param Queue $queue
     * @return Queue
     */
    public function dequeue(Queue $queue) : Queue
    {
        /* @var $message Message*/
        $message = $queue->bottom();

        $queue->truncate();
        $queue = $this->get($queue);

        if ($queue->bottom()->getId() == $message->getId()) {
            $queue->dequeue();
            $this->put($queue);
        }

        $queue->truncate();
        return $this->get($queue);
    }

    /**
     * @param string $flag
     */
    private function startTransaction(string $flag)
    {
        $this->storage =  fopen($this->fileName, (file_exists($this->fileName)) ? $flag : 'w');
    }

    /**
     *
     */
    private function finishTransaction()
    {
        fclose($this->storage);
        unset($this->storage);
    }
}