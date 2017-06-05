<?php

namespace Collection;

use Entity\Consumer;

/**
 * Class ScaledGroup
 * @package Collection
 */
class AutoScalingGroup
{
    /**
     * @var array
     */
    private $consumers = [];

    /**
     * @var int
     */
    private $maxSize;

    /**
     * ScaledGroup constructor.
     * @param int $maxSize
     */
    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @return int
     */
    public function getCount() : int
    {
        return count($this->consumers);
    }

    /**
     * @return Consumer|null
     */
    public function getFreeConsumer()
    {
        /* @var Consumer $consumer */
        foreach ($this->consumers as $consumer) {
            if ($consumer->checkIfFree()) {
                return $consumer;
            }
        }
        return $this->addConsumer();
    }

    /**
     * @return Consumer|null
     */
    private function addConsumer()
    {
        if (count($this->consumers) < $this->maxSize) {
            $consumer = new Consumer(count($this->consumers));
            $this->consumers[] = $consumer;
            return $consumer;
        }
        return null;
    }

    /**
     *
     */
    public function flush()
    {
        foreach ($this->consumers as $consumer) {
            if ($consumer->checkIfFree()) {
                unset($this->consumers[$consumer->getId()]);
            }
        }
    }

}