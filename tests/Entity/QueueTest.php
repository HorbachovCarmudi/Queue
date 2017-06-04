<?php

use PHPUnit\Framework\TestCase;
use Entity\Queue;

/**
 * Class QueueTest
 */
final class QueueTest extends TestCase
{
    public function testEnqueue()
    {
        $testSize = 2;
        $first = 'A';
        $second = 'B';
        $third = 'C';

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

        $class = new ReflectionClass('Entity\Queue');
        $property = $class->getProperty('size');
        $property->setAccessible(true);

        $this->assertEquals($testSize, $property->getValue($queue));
    }
}
