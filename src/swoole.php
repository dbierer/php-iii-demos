<?php
require __DIR__ . '/lib.php';
use App\Lorem\Ipsum;
use Swoole\Coroutine as Co;
use function Swoole\Coroutine\Http\get;

$start  = microtime(TRUE);
Co\run(function()
{
    go(function()
    {
        echo ntp();
    });

    go(function()
    {
        // Using Swoole HTTP client instead of `file_get_contents()`
        echo get(Ipsum::API_URL)->getBody();
    });

    go(function()
    {
        echo prime();
    });

    go(function()
    {
        echo city();
    });

});
echo "\n\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";
