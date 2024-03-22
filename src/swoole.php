<?php
require __DIR__ . '/lib.php';
use App\Lorem\Ipsum;
use Swoole\Coroutine as Co;
use function Swoole\Coroutine\Http\get;

$start  = microtime(TRUE);
Co\run(function()
{
	for ($x = 1; $x < 10; $x++) {
		/*
		go(function()
		{
			echo ntp();
		});
		*/

		go(function()
		{
			// You could also use the Swoole HTTP client instead of `file_get_contents()`
			// However Swoole would need to be compiled with the `--enable-openssl` flag
			// echo get(Ipsum::API_URL)->getBody();
			echo ipsum();
		});
		
		go(function()
		{
			echo prime();
		});

		go(function()
		{
			echo city();
		});
	}
});
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";
