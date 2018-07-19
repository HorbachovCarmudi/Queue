<?php

use PHPUnit\Framework\TestCase;
use Entity\Message;

/**
* Class MessageTest
*/
final class MessageTest extends TestCase
{
    public function testConstruct()
    {
        $testId = 3;
        $testSeconds = 1;

        $message = new Message($testId, $testSeconds);
        $this->assertEquals($testId, $message->getId());
        $this->assertEquals($testSeconds, $message->getSecondsToExecute());
    }
}
