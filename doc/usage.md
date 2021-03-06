# Usage

To send a request, you can use the API defined by the `Ivory\HttpAdapter\HttpAdapterInterface`. All these methods
throw an `Ivory\HttpAdapter\HttpAdapterException` if an error occurred (I would recommend you to always use a try/catch
block everywhere) and return an `Ivory\HttpAdapter\Message\ResponseInterface`. If you want to learn more about the
response, you can read this [doc](/doc/response.md).

Additionally, the url can be a string or an object implementing the `__toString` method. The headers parameter can be
an associative array describing an header key/value pair or an indexed array already formatted. The datas can be an
associative array or a string already formatted according to the content-type you want to use. Finally, the files are
an associative array describing key/path pair.

## Send a GET request

``` php
$response = $httpAdapter->get($url, $headers);
```

## Send an HEAD request

``` php
$response = $httpAdapter->head($url, $headers);
```

## Send a TRACE request

``` php
$response = $httpAdapter->trace($url, $headers);
```

## Send a POST request

``` php
$response = $httpAdapter->post($url, $headers, $datas, $files);
```

## Send a PUT request

``` php
$response = $httpAdapter->put($url, $headers, $datas, $files);
```

## Send a PATCH request

``` php
$response = $httpAdapter->patch($url, $headers, $datas, $files);
```

## Send a DELETE request

``` php
$response = $httpAdapter->delete($url, $headers, $datas, $files);
```

## Send an OPTIONS request

``` php
$response = $httpAdapter->options($url, $headers, $datas, $files);
```

## Send a request

``` php
$response = $httpAdapter->send($url, $method, $headers, $datas, $files);
```

All methods are described by the `Ivory\HttpAdapter\Message\RequestInterface::METHOD_*` constants.

## Send a PSR-7 request

``` php
use Ivory\HttpAdapter\Message\InternalRequest;
use Ivory\HttpAdapter\Message\Request;

$response = $httpAdapter->sendRequest(new Request($url, $method));
// or
$response = $httpAdapter->sendRequest(new InternalRequest($url, $method));
```

If you want to learn more about the `Ivory\HttpAdapter\Message\Request`, your can read this [doc](/doc/request.md) or
if you want to learn more about the `Ivory\HttpAdapter\Message\InternalRequest`, your can read this
[doc](/doc/internal_request.md).

## Send multiple requests

``` php
use Ivory\HttpAdapter\Message\InternalRequest;
use Ivory\HttpAdapter\Message\Request;
use Ivory\HttpAdapter\MultiHttpAdapterException;

$requests = array(
    // An url (GET 1.1)
    'http://egeloen.fr',

    // An array representing the parameters of the `MessageFactoryInterface::createInternalRequest`
    array('http://egeloen.fr', 'GET', 1.1, array('Content-Type' => 'json', '{"foo":"bar"}')),

    // A PSR-7 request
    new Request('http://egeloen.fr', 'GET'),

    // An internal request
    new InternalRequest('http://egeloen.fr', 'GET'),
);

try {
    $responses = $httpAdapter->sendRequests($requests);
} catch (MultiHttpAdapterException $e) {
    $responses = $e->getResponses();
    $exceptions = $e->getExceptions();
}
```

You can additionaly pass two callables which will be triggered as soon as a request is completed:

``` php
use Ivory\HttpAdapter\HttpAdapterException;
use Ivory\HttpAdapter\Message\ResponseInterface;
use Ivory\HttpAdapter\MultiHttpAdapterException;

$success = function (ResponseInterface $response) {
    $request = response->getParameter('request');
};

$error = function (HttpAdapterException $exception) {
    $request = $exception->getRequest();

    if ($exception->hasResponse()) {
        $response = $exception->getResponse();
    }
};

$responses = $httpAdapter->sendRequests($requests, $success, $error);
```

The method will not throw an exception if you pass the `error` callable.
