<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Ntp\Client;
use App\Lorem\Ipsum;
use App\Number\Prime;
use App\Weather\Forecast;
use App\Geonames\{Random,Build};

// NTP request
function ntp()
{
    $client = new Client();
    $error  = [];
    $output = "NTP Time:\n";
    $output .= var_export($client->getTime($error), TRUE);
    return $output . PHP_EOL;
}
function ipsum()
{
    $output = "Lorem Ipsum:\n";
    $contents = Ipsum::getHtml();
    preg_match_all('!<p>(.*?)</p>!', $contents, $matches);
    $output .= $matches[1][0] ?? 'Unknown';
    return $output . PHP_EOL;
}
function prime()
{
    $output = '';
    $start = 9000;
    $end   = 9999;
    $primes = Prime::generate($start, $end);
    foreach ($primes as $number) $output .= $number . ' ';
    return $output . PHP_EOL;
}
function weather()
{
    // Pick random city
    $output = '';
    $geonamesFile = __DIR__ . '/../data/' . Random::GEONAMES_FILTERED;
    if (!file_exists($geonamesFile)) {
        $output .= "\nShort Geonames file doesn't exist\n"
             . "To build the file, prceed as follows:\n"
             . "wget " . Build::GEONAMES_URL . "\n"
             . "unzip -o data/" . Build::GEONAMES_SHORT . "\n"
             . "App\Geonames\Build::buildShort()\n"
             . "App\Geonames\Build::filterByCountry('US', \$src, \$dest)\n";
        $output .= "\nYou need to filter by US because the (free) US weather service only provides weather for the USA\n";
    }
    $city = Random::pickCity();
    $output .= "Random City Info:\n";
    $output .= var_export($city, TRUE);
    // Weather Forecast for Random City
    if (!empty($city[2])) {
        $name = $city[2];
        $lat  = $city[3];
        $lon  = $city[4];
        $output .= "Weather forecast for $name\n";
        $output .= (new Forecast())->getForecast($lat, $lon);
    }
    return $output . PHP_EOL;
}
