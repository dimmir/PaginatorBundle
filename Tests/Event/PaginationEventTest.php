<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Event;

use DMR\Bundle\PaginatorBundle\Event\PaginationEvent;
use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class PaginationEventTest extends TestCase
{
    public function testOptions()
    {
        $event = new PaginationEvent();

        $event->addOption('test_option_key', 'test_option_value');

        $this->assertEquals('test_option_value', $event->getOption('test_option_key'));
        $this->assertEmpty($event->getOption('not_exist_key'));
        $this->expectException(RuntimeException::class);
        $event->addOption('test_option_key', 'test_option_value');
    }
}
