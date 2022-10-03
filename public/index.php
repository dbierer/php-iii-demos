<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Ntp\Client;
use App\Lorem\Ipsum;
use App\Number\Prime;
use App\Weather\Forecast;
use App\Geonames\{Random,Build};
// record start time
$quit   = TRUE;
$start  = microtime(TRUE);
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'ntp' :
        // NTP request
        $error  = [];
        $client = new Client();
        echo "NTP Time:\n";
        var_dump($client->getTime($error));
        break;
    case 'ipsum' :
        echo "Lorem Ipsum:\n";
        $contents = Ipsum::getHtml();
        preg_match_all('!<p>(.*?)</p>!', $contents, $matches);
        echo $matches[1][0] ?? 'Unknown';
        break;
    case 'prime' :
        $start = rand(1,9) * 1000;
        $end   = $start + 1000;
        $primes = Prime::generate($start, $end);
        foreach ($primes as $number) echo $number . ' ';
        break;
    case 'weather' :
        // Pick random city
        $geonamesFile = __DIR__ . '/../data/' . Random::GEONAMES_FILTERED;
        if (!file_exists($geonamesFile)) {
            echo "\nShort Geonames file doesn't exist\n"
                 . "To build the file, prceed as follows:\n"
                 . "wget " . Build::GEONAMES_URL . "\n"
                 . "unzip -o data/" . Build::GEONAMES_SHORT . "\n"
                 . "App\Geonames\Build::buildShort()\n"
                 . "App\Geonames\Build::filterByCountry('US', \$src, \$dest)\n";
            echo "\nYou need to filter by US because the (free) US weather service only provides weather for the USA\n";
        }
        $city = Random::pickCity();
        echo "Random City Info:\n";
        var_dump($city);
        // Weather Forecast for Random City
        if (!empty($city[2])) {
            $name = $city[2];
            $lat  = $city[3];
            $lon  = $city[4];
            echo "Weather forecast for $name\n";
            echo (new Forecast())->getForecast($lat, $lon);
        }
        break;
    default :
        $quit = FALSE;
}
if ($quit) {
    // report elapsed time
    echo "\n\n<br />Elapsed Time: " . (microtime(TRUE) - $start) . "\n";
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
