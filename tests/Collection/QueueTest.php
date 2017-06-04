<?php

use PHPUnit\Framework\TestCase;
use Collection\Queue;
use Entity\Message;

/**
 * Class QueueTest
 */
final class QueueTest extends TestCase
{
    public function testEnqueue()
    {
        $testSize = 2;
        $first = new Message(1, 1);
        $second = new Message(2, 1);
        $third = new Message(3, 1);

        $queue = new Queue($testSize);
        $queue->enqueue($first);
        $queue->enqueue($second);
        $queue->enqueue($third);

        $this->assertEquals($testSize, $queue->count());
        $this->assertEquals($second, $queue->bottom());
        $this->assertEquals($third, $queue->top());
    }

    public function testConstruct()
    {
        $testSize = 3;

        $queue = new Queue($testSize);

        $class = new ReflectionClass('Collection\Queue');
        $property = $class->getProperty('size');
        $property->setAccessible(true);

        $this->assertEquals($testSize, $property->getValue($queue));
    }
}
