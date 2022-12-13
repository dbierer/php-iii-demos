--TEST--
Check if hello is loaded
--EXTENSIONS--
hello
--FILE--
<?php
echo 'The extension "hello" is available';
?>
--EXPECT--
The extension "hello" is available
