<?php
require __DIR__ . '/lib.php';
// record start time
$start = microtime(TRUE);

$fibers = [];

for ($x = 1; $x < 10; $x++) {
    //new Fiber(function () { echo ntp();   }),
    $fibers[] = new Fiber(function () { echo ipsum(); });
    $fibers[] = new Fiber(function () { echo prime(); });
	$fibers[] = new Fiber(function () { echo city();  });
}

foreach ($fibers as $func) $func->start();

// report elapsed time
echo "\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";

// 6.6285440921783
// 6.5927429199219
// 6.4565069675446
