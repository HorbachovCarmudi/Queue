<?php

namespace Entity;

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
     * @param mixed $value
     */
    public function enqueue($value)
    {
        if ($this->count() == $this->size) {
            $this->dequeue();
        }
        parent::enqueue($value);
    }
}




