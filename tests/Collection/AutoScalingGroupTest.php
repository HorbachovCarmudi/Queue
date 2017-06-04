<?php

use PHPUnit\Framework\TestCase;
use Collection\AutoScalingGroup;
use Entity\Message;

/**
 * Class AutoScalingGroup
 */
final class AutoScalingGroupTest extends TestCase
{

    public function testConstruct()
    {
        $groupSize = 2;
        $group = new AutoScalingGroup($groupSize);

        $class = new ReflectionClass('Collection\AutoScalingGroup');
        $property = $class->getProperty('maxSize');
        $property->setAccessible(true);

        $this->assertEquals($groupSize, $property->getValue($group));
    }

    public function testAddConsumer()
    {
        $groupSize = 2;
        $group = new AutoScalingGroup($groupSize);

        $class = new ReflectionClass('Collection\AutoScalingGroup');
        $method = $class->getMethod('addConsumer');
        $method->setAccessible(true);
        $method->invoke($group);
        $method->invoke($group);
        $method->invoke($group);

        $this->assertEquals($groupSize, $group->getCount());
    }

    public function testGetFreeConsumer()
    {
        $groupSize = 3;
        $group = new AutoScalingGroup($groupSize);

        $consumer = $group->getFreeConsumer();
        $consumer->proceed(new Message(1,1));
        $this->assertEquals(1, $group->getCount());

        $consumer = $group->getFreeConsumer();
        $consumer->proceed(new Message(1,0));
        $this->assertEquals(2, $group->getCount());

        $consumer = $group->getFreeConsumer();
        $consumer->proceed(new Message(1,1));
        $this->assertEquals(2, $group->getCount());
    }
}
