<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use React\Stream\ReadableStreamInterface;
use React\Stream\WritableStreamInterface;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

use const PHP_INT_MAX;

final class DifferentStreamTypesTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function cantReadFromWritableStream(): void
    {
        $this->expectExceptionMessage('Can\'t read from a write only stream');

        $writableStream = $this->prophesize(WritableStreamInterface::class);
        $stream         = new Stream($writableStream->reveal());

        $stream->read(PHP_INT_MAX);
    }

    /**
     * @test
     */
    public function cantGetContentsFromWritableStream(): void
    {
        $this->expectExceptionMessage('Can\'t read from a write only stream');

        $writableStream = $this->prophesize(WritableStreamInterface::class);
        $stream         = new Stream($writableStream->reveal());

        $stream->getContents();
    }

    /**
     * @test
     */
    public function cantCastWritableStreamToString(): void
    {
        $this->expectExceptionMessage('Can\'t read from a write only stream');

        $writableStream = $this->prophesize(WritableStreamInterface::class);
        $stream         = new Stream($writableStream->reveal());

        $void = (string) $stream;
    }

    /**
     * @test
     */
    public function cantWriteToReadableStream(): void
    {
        $this->expectExceptionMessage('Can\'t write to a read only stream');

        $readableStream = $this->prophesize(ReadableStreamInterface::class);
        $stream         = new Stream($readableStream->reveal());

        $stream->write('Hello World');
    }
}
