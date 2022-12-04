<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\PSR7;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Loop;
use React\Http\Browser;
use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;
use React\Stream\ReadableStreamInterface;
use React\Stream\ThroughStream;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\PSR7\Stream;

use function assert;
use function implode;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\Timer\sleep;
use function str_replace;
use function strlen;

use const PHP_INT_MAX;

final class StreamTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function while(): void
    {
        $ticks   = 0;
        $content = '';
        Loop::futureTick(async(static function () use (&$ticks, &$content): void {
            $response = await((new Browser())->requestStreaming('GET', 'https://example.com'));
            assert($response instanceof ResponseInterface);
            $body = $response->getBody();
            assert($body instanceof ReadableStreamInterface);
            $stream = new Stream($body);
            while (! $stream->eof()) {
                $ticks++;
                $content .= $stream->read(PHP_INT_MAX);
            }
        }));
        Loop::run();

        self::assertGreaterThan(1, $ticks);
        self::assertGreaterThan(1, strlen($content));
    }

    /**
     * @test
     */
    public function cast(): void
    {
        $content = '';
        Loop::futureTick(async(static function () use (&$content): void {
            $response = await((new Browser())->requestStreaming('GET', 'https://example.com'));
            assert($response instanceof ResponseInterface);
            $body = $response->getBody();
            assert($body instanceof ReadableStreamInterface);
            $stream   = new Stream($body);
            $content .= (string) $stream;
        }));
        Loop::run();

        self::assertGreaterThan(1, strlen($content));
    }

    /**
     * @test
     */
    public function write(): void
    {
        $writtenContent = '';
        $content        = [
            'a',
            'b',
            'c',
            'd',
        ];

        $socketServer = new SocketServer('tcp://127.0.0.1:0');
        $httpServer   = new HttpServer(static function (ServerRequestInterface $request) use (&$writtenContent, $socketServer): ResponseInterface {
            $socketServer->close();
            $writtenContent = (string) $request->getBody();

            return new Response();
        });
        $httpServer->listen($socketServer);

        Loop::futureTick(async(static function () use ($socketServer, $content): void {
            $throughStream = new ThroughStream();
            $stream        = new Stream($throughStream);
            (new Browser())->request('POST', str_replace('tcp://', 'http://', (string) $socketServer->getAddress()), [], $throughStream);

            foreach ($content as $wait => $data) {
                $stream->write($data);
                await(sleep($wait));
            }

            $throughStream->end();
        }));

        Loop::run();

        self::assertSame(implode('', $content), $writtenContent);
    }
}
