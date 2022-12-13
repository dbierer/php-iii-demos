--TEST--
test1() Basic test
--EXTENSIONS--
hello
--FILE--
<?php
$ret = test1();

var_dump($ret);
?>
--EXPECT--
The extension hello is loaded and working!
NULL
