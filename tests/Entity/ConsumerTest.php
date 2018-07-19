<?php

use PHPUnit\Framework\TestCase;
use Entity\Consumer;
use Entity\Message;

/**
* Class ConsumerTest
*/
final class ConsumerTest extends TestCase
{
    public function testConstruct()
    {
        $testId = 3;
        $consumer = new Consumer($testId);
        $this->assertEquals($testId, $consumer->getId());
    }

    public function testCheckIfFreeSuccess()
    {
        $testId = 3;
        $consumer = new Consumer($testId);

        $message = new Message(1, 0);
        $consumer->proceed($message);
        $this->assertEquals(true, $consumer->checkIfFree());
    }

    public function testCheckIfFreeFail()
    {
        $testId = 3;
        $consumer = new Consumer($testId);

        $message = new Message(1, 1);
        $consumer->proceed($message);
        $this->assertEquals(false, $consumer->checkIfFree());
    }

    public function testCheckProceedException()
    {
        $this->expectException('\Exception');

        $testId = 3;
        $consumer = new Consumer($testId);

        $message = new Message(1, 1);
        $consumer->proceed($message);
        $consumer->proceed($message);
    }
}
