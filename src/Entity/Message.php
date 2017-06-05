<?php

namespace Entity;

/**
 * Class Message
 * @package Entity
 */
final class Message
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $secondsToExecute;

    /**
     * Message constructor
     * @param $id string
     * @param $secondsToExecute int
     */
    public function __construct(string $id, int $secondsToExecute)
    {
        $this->id = $id;
        $this->secondsToExecute = $secondsToExecute;
    }

    /**
     * @return string
     */
    public function getId() : string
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