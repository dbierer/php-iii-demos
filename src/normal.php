<?php
require __DIR__ . '/lib.php';

$start  = microtime(TRUE);
for ($x = 1; $x < 10; $x++) {
	// echo ntp();
	echo ipsum();
	echo prime();
	echo city();
}
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";

// 10.089123010635
//  6.6656608581543
//  6.5485470294952
//  6.4534080028534
