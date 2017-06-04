<?php

namespace Entity;

/**
 * Class Message
 * @package Entity
 */
class Message
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $secondsToExecute;

    /**
     * Message constructor
     * @param $id int
     * @param $secondsToExecute int
     */
    public function __construct(int $id, int $secondsToExecute)
    {
        $this->id = $id;
        $this->secondsToExecute = $secondsToExecute;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSecondsToExecute(): int
    {
        return $this->secondsToExecute;
    }
}