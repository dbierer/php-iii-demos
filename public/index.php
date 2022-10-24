<?php
require __DIR__ . '/../src/lib.php';
// record start time
$start  = microtime(TRUE);
$action = $_GET['action'] ?? $argv[1] ?? '';
$output = match($action) {
    'ntp'   => ntp(),
    'ipsum' => ipsum(),
    'prime' => prime(),
    'city'  => city(),
    'weather' => weather(),
    default => ''
};
if (!empty($output)) {
    // report elapsed time
    $output = "Normal PHP\n" . $output;
    $output .= "\n\n<br />Elapsed Time: " . (microtime(TRUE) - $start) . "\n";
    echo $output;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>PHP III Demos</title>
<meta name="generator" content="Geany 1.36" />
<style>
.border_whatever {
    border: thin solid black;
}
.dims {
    width: 100%;
    height: 350px;
}
a {
    cursor: pointer;
}
</style>
</head>
<body>
<!-- To run the demo, start a PHP web server instance from the project root: "php -S localhost:8888 -t public" -->
<a href="reactphp.html">ReactPHP</a>
<table width="80%" border=1>
<tr>
    <td width="50%">
    <a name="ntp" id="ntp">NTP</a>
    <hr />
    <div id="A" class="dims"></div>
    </td>
    <td rowspan=3 valign="top" width="50%">
    <a name="weather" id="weather">Weather</a>
    <hr />
    <div id="D" class="dims"></div>
    </td>
</tr>
<tr>
    <td width="50%">
    <a name="ipsum" id="ipsum">Ipsum</a>
    <hr />
    <div id="B" class="dims"></div>
    </td>
</tr>
<tr>
    <td width="50%">
    <a name="prime" id="prime">Prime</a>
    <hr />
    <div id="C" class="dims"></div>
    </td>
</tr>
</table>
<!-- load jQuery -->
<script language="javascript" src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<!-- On button click, make AJAX request -->
<script>
$(document).ready(function () {
    $('#ntp').click(function () {
        $.ajax({
            url: '/index.php?action=ntp',
            dataType : 'html',
            success: function(data) {
                $('#A').html(data);
            }
        });
    });
    $('#ipsum').click(function () {
        $.ajax({
            url: '/index.php?action=ipsum',
            dataType : 'html',
            success: function(data) {
                $('#B').html(data);
            }
        });
    });
    $('#prime').click(function () {
        $.ajax({
            url: '/index.php?action=prime',
            dataType : 'html',
            success: function(data) {
                $('#C').html(data);
            }
        });
    });
    $('#weather').click(function () {
        $.ajax({
            url: '/index.php?action=weather',
            dataType : 'html',
            success: function(data) {
                $('#D').html(data);
            }
        });
    });
});
</script>
</body>
</html>
