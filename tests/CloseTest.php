<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use React\Stream\DuplexStreamInterface;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

final class CloseTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function close(): void
    {
        $duplexStream = $this->prophesize(DuplexStreamInterface::class);
        $duplexStream->close()->shouldBeCalled()->willReturn(false);
        $stream = new Stream($duplexStream->reveal());

        $stream->close();
    }
}
