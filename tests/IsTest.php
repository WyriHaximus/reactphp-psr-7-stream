<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use React\Stream\DuplexStreamInterface;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

final class IsTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function underscoreIsReadable(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $duplexStream->isReadable()->shouldBeCalled()->willReturn(false);
        $stream = new Stream($duplexStream->reveal());

        self::assertFalse($stream->isReadable());
    }

    /**
     * @test
     */
    public function underscoreIsWritable(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $duplexStream->isWritable()->shouldBeCalled()->willReturn(false);
        $stream = new Stream($duplexStream->reveal());

        self::assertFalse($stream->isWritable());
    }
}
