# ReactPHP PSR-7 Stream

🎁 Decorate ReactPHP streams as PSR-7 streams

![Continuous Integration](https://github.com/wyrihaximus/reactphp-psr-7-stream/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/wyrihaximus/react-psr-7-stream/v/stable.png)](https://packagist.org/packages/wyrihaximus/react-psr-7-stream)
[![Total Downloads](https://poser.pugx.org/wyrihaximus/react-psr-7-stream/downloads.png)](https://packagist.org/packages/wyrihaximus/react-psr-7-stream/stats)
[![Code Coverage](https://coveralls.io/repos/github/WyriHaximus/reactphp-psr-7-stream/badge.svg?branchmain)](https://coveralls.io/github/WyriHaximus/reactphp-psr-7-stream?branch=main)
[![Type Coverage](https://shepherd.dev/github/WyriHaximus/reactphp-psr-7-stream/coverage.svg)](https://shepherd.dev/github/WyriHaximus/reactphp-psr-7-stream)
[![License](https://poser.pugx.org/wyrihaximus/react-psr-7-stream/license.png)](https://packagist.org/packages/wyrihaximus/react-psr-7-stream)

# Installation

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/react-psr-7-stream
```

# Usage

This package assumes you run all code using it inside fibers. The following example makes a HTTP request using
[`react/http`](https://reactphp.org/http/#streaming-response), decorates the body, and loops over it until the full
body has been received. Important, while looping, do not use any other [`await`](https://reactphp.org/async/#await)
calls whatsoever inside the loop. Doing so might make you miss a `data` event from the `ReadableStreamInterface`. This
package is build for high performance low memory usage, it will not buffer data for you.

```php
$response = await((new Browser())->requestStreaming('GET', 'https://example.com'));
assert($response instanceof ResponseInterface);
$body = $response->getBody();
assert($body instanceof ReadableStreamInterface);
$stream = new Stream($body);
while (! $stream->eof()) {
    handleDataChunk($stream->read(PHP_INT_MAX));
}
```

# License

The MIT License (MIT)

Copyright (c) 2023 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

