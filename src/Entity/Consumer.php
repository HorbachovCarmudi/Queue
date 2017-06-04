<?php

namespace Entity;

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
}