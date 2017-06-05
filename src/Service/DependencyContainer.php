<?php

namespace Service;

use Entity\Message;
use Entity\Consumer;

/**
 * Class DependencyContainer
 * @package Service
 */
class DependencyContainer
{
    /**
     * @param $params
     * @return Message
     */
    public function getMessage($params) : Message
    {
        return new Message(...$params);
    }

    /**
     * @param $params
     * @return Consumer
     */
    public function getConsumer($params) : Consumer
    {
        return new Consumer(...$params);
    }
}