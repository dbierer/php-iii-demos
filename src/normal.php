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
