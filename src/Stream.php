<?php

declare(strict_types=1);

namespace WyriHaximus\React\PSR7;

use Psr\Http\Message\StreamInterface;
use React\Stream\ReadableStreamInterface;
use React\Stream\WritableStreamInterface;

use function React\Async\await;
use function React\Promise\Stream\buffer;
use function React\Promise\Stream\first;

// phpcs:disabled
final class Stream implements StreamInterface
{
    public function __construct(
        private ReadableStreamInterface|WritableStreamInterface $stream,
    ) {

    }

    /**
     * @psalm-suppress MethodSignatureMustProvideReturnType
     */
    public function __toString()
    {
        return $this->getContents();
    }

    public function close()
    {
        $this->stream->close();
    }

    public function detach()
    {
        return null;
    }

    public function getSize()
    {
        throw new \RuntimeException('GetSize not supported');
    }

    public function tell()
    {
        throw new \RuntimeException('Tell not supported');
    }

    public function eof()
    {
        return !$this->isReadable() && !$this->isWritable();
    }

    public function isSeekable()
    {
        return false;
    }

    /**
     * @phpstan-ignore-next-line
     * @psalm-suppress MissingReturnType
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException('Seek not supported');
    }

    /**
     * @phpstan-ignore-next-line
     * @psalm-suppress MissingReturnType
     */
    public function rewind()
    {
        throw new \RuntimeException('Rewind not supported');
    }

    public function isWritable()
    {
        return $this->stream instanceof WritableStreamInterface && $this->stream->isWritable();
    }

    public function write($string)
    {
        if (!($this->stream instanceof WritableStreamInterface)) {
            throw new \RuntimeException('Can\'t write to a read only stream');
        }

        $this->stream->write($string);

        return strlen($string);
    }

    public function isReadable()
    {
        return $this->stream instanceof ReadableStreamInterface && $this->stream->isReadable();
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     */
    public function read($length)
    {
        if (!($this->stream instanceof ReadableStreamInterface)) {
            throw new \RuntimeException('Can\'t read from a write only stream');
        }

        /**
         * @phpstan-ignore-next-line
         * @psalm-suppress MixedReturnStatement
         */
        return await(first($this->stream));
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     */
    public function getContents()
    {
        if (!($this->stream instanceof ReadableStreamInterface)) {
            throw new \RuntimeException('Can\'t read from a write only stream');
        }

        /**
         * @phpstan-ignore-next-line
         * @psalm-suppress MixedReturnStatement
         */
        return await(buffer($this->stream));
    }

    /** @phpstan-ignore-next-line  */
    public function getMetadata($key = null)
    {
        return null;
    }
}
