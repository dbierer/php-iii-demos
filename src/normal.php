<?php
require __DIR__ . '/lib.php';

$start  = microtime(TRUE);
echo ntp();
echo ipsum();
echo prime();
echo city();
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";
