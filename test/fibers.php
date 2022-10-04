<?php
require __DIR__ . '/lib.php';
// record start time
$start = microtime(TRUE);

$fibers = [
    new Fiber(function () {
		echo ntp();
    }),
    new Fiber(function () {
		echo ipsum();
    }),
    new Fiber(function () {
		echo prime();
    }),
];

foreach ($fibers as $func) $func->start();

// report elapsed time
echo "\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";

