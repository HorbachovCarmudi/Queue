<?php

namespace Entity;

use Logger;

/**
 * Class Consumer
 * @package Entity
 */
final class Consumer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $free = true;

    /**
     * @var int
     */
    private $willBeFreeAfter ;

    /**
     * Consumer constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->logInfo('[I-' . $this->getId() . '] created');
    }

    /**
     * @param Message $message
     * @throws \Exception
     */
    public function proceed(Message $message)
    {
        if ($this->checkIfFree()) {
            $this->willBeFreeAfter = time() + $message->getSecondsToExecute();
            $this->free = false;

            $this->logInfo('[I-' .$this->getId() . '] started message ' . $message->getId()
                . ', execution time: ' . $message->getSecondsToExecute() . ' seconds'
            );

        } else {
            throw new \Exception('Try to proceed message on Busy Consumer');
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function checkIfFree() : bool
    {
        if (time() >= $this->willBeFreeAfter) {
            $this->free = true;
        }
        return $this->free;
    }

    private function logInfo($message)
    {
        Logger::getLogger('consumer')->info($message);
    }

    public function __destruct() {
        $this->logInfo('[I-' . $this->getId() . '] destroyed');
    }
}