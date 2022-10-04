<?php
require __DIR__ . '/lib.php';
use React\Promise\Promise;

// init vars
$start  = microtime(TRUE);

React\Async\series([
    function () { return new Promise(function ($resolve) { $resolve(ntp());}); },
    function () { return new Promise(function ($resolve) { $resolve(ipsum());}); },
    function () { return new Promise(function ($resolve) { $resolve(prime());}); },
])->then(function (array $results) {
    foreach ($results as $result) {
        var_dump($result);
    }
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";

