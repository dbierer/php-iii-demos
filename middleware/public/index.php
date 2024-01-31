<?php
// to run the demo:
/*
 * cd /path/to/project
 * php -S localhost:0.0.0.0:9999 -t public
 * 
 * GET request:
 * curl -X GET http://localhost:9999
 * 
 * POST request:
 * curl -X POST \
    -F status=open \
    -F amount=88.88 \
    -F description="Covid-19 vaccine" \
    -F customer=1 \
    http://localhost:9999
*/

define('LOG_FILE', __DIR__ . '/../logs/access.log');
define('DB_CONFIG', ['dbname' => 'phpcourse', 'dbuser' => 'vagrant', 'dbpwd' => 'vagrant']);
require __DIR__ . '/../vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\JsonResponse;
use Middleware\{
    Logger, ListHandler, InsertHandler,
    DeleteHandler, NextHandler };
// build the pipe
$pipe = [
    Logger::class => NextHandler::class,
    DeleteHandler::class => NextHandler::class,
    InsertHandler::class => NextHandler::class,
    ListHandler::class => NULL,
];
// build a PSR-7 Request object
$request  = ServerRequestFactory::fromGlobals();

// run the pipe
foreach ($pipe as $key => $val) {
    $middleware = new $key();
    $handler    = (!empty($val)) ? new $val() : NULL;
    if (method_exists($middleware, 'process')) {
        $response = $middleware->process($request, $handler);
    } else {
        $response = $middleware->handle($request);
    }
    // check response: is it time to stop?
    $code = $response->getStatusCode();
    if ($code !== 202) break;
}
echo $response->getBody();
