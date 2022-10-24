<?php
require __DIR__ . '/../src/lib.php';

$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) {

    $start  = microtime(TRUE);
    $action = $request->getQueryParams()['action'] ?? '';
    $output = match($action) {
        'ntp'   => ntp(),
        'ipsum' => ipsum(),
        'prime' => prime(),
        'city'  => city(),
        'weather' => weather(),
        default => ''
    };
    if (!empty($output)) {
        // report elapsed time
        $output = "Normal PHP\n" . $output;
        $output .= "\n\n<br />Elapsed Time: " . (microtime(TRUE) - $start) . "\n";
    }
    return React\Http\Message\Response::plaintext($output);

});

$socket = new React\Socket\SocketServer('127.0.0.1:8222');
$http->listen($socket);

echo "Server running at http://127.0.0.1:8222" . PHP_EOL;
