<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use React\Stream\DuplexStreamInterface;
use RuntimeException;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

final class UnsupportedMethodsTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function underscoreGetSize(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('GetSize not supported');

        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        $stream->getSize();
    }

    /**
     * @test
     */
    public function tell(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Tell not supported');

        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        $stream->tell();
    }

    /**
     * @test
     */
    public function seek(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Seek not supported');

        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        $stream->seek(13);
    }

    /**
     * @test
     */
    public function rewind(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Rewind not supported');

        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $stream       = new Stream($duplexStream->reveal());

        $stream->rewind();
    }
}
