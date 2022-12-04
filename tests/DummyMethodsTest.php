<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use React\Stream\DuplexStreamInterface;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

final class DummyMethodsTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function detach(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        self::assertNull($stream->detach());
    }

    /**
     * @test
     */
    public function isSeekable(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        self::assertFalse($stream->isSeekable());
    }

    /**
     * @test
     */
    public function getMetadata(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        self::assertNull($stream->getMetadata());
    }
}
