<?php

namespace Collection;

use Entity\Message;

/**
 * Class Queue
 */
final class Queue extends \SplQueue
{
    /**
     * @var integer
     */
    private $size;

    /**
     * Queue constructor
     * @param $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
    }

    /**
     * @param Message $value
     */
    public function enqueue($value)
    {
        if ($this->count() == $this->size) {
            $this->dequeue();
        }
        parent::enqueue($value);
    }
}




