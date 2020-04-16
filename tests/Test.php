<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;

class Test extends TestCase
{
    public function testA() {

        $stubB = $this->createMock(B::class);
        $stubB->method('testMethod')->willReturn(2);

        $stubA = $this->createMock(A::class);
        $stubA->method('testMethod')->willReturn($stubB);

        $this->assertTrue(true);
    }

    public function testB() {
        $expectedObject = new stdClass;

        $mock = $this->getMockBuilder(A::class)
            ->setMethods(['foo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }

    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }

    /**
     * @depends testProducerSecond
     * @depends testProducerFirst
     */
    public function testConsumer($a, $b)
    {
        $this->assertSame('first', $b);
        $this->assertSame('second', $a);
    }
}

class A {
    public function testMethod() : B {

    }
}

class B {
    public function testMethod(Animal $animal) {

    }
}