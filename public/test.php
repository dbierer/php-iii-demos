<?php
include __DIR__ . '/../vendor/autoload.php';
use App\Ntp\Client;
use React\EventLoop\Loop;
use React\Promise\Promise;

$ntp = function () {
    $client = new Client();
    $output = "NTP Time:\n";
    $output .= var_export($client->getTime($error), TRUE);
    return $output;
};

React\Async\series([
    function () {
        return new Promise(function ($resolve) {
            $client = new Client();
            $output = "NTP Time:\n";
            $output .= var_export($client->getTime($error), TRUE);
            $resolve($output);
        });
    },
    function () {
        return new Promise(function ($resolve) {
            Loop::addTimer(1, function () use ($resolve) {
                $resolve('Slept for another whole second');
            });
        });
    },
    function () {
        return new Promise(function ($resolve) {
            Loop::addTimer(1, function () use ($resolve) {
                $resolve('Slept for yet another whole second');
            });
        });
    },
])->then(function (array $results) {
    foreach ($results as $result) {
        var_dump($result);
    }
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});
