<?php
require __DIR__ . '/lib.php';
use Swoole\Coroutine as Co;

$start  = microtime(TRUE);
echo ntp();
echo ipsum();
echo prime();
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";
