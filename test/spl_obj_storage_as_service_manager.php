<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Service\Manager;
use App\Ntp\Client;
use App\Lorem\Ipsum;
use App\Number\Prime;
use App\Weather\Forecast;
use App\Geonames\{Random,Build};

// load services
$container = new Manager();
$container->add(new Client(), 'ntp');
$container->add(function () { return Ipsum::getHtml(); }, 'ipsum');
$container->add(function ($start, $end) { return Prime::generate($start, $end); }, 'prime');
$container->add(function () { return Random::pickCity(); }, 'city');

// get action from CLI
$output = '';
$action = trim($argv[1] ?? '');
switch ($action) {
    // NTP request
    case 'ntp' :
        $client = $container->get(Client::class);
        $error  = [];
        $output = "NTP Time:\n";
        $output .= var_export($client->getTime($error), TRUE);
        break;
    case 'ipsum' :
        $output = "Lorem Ipsum:\n";
        $contents = $container->get('ipsum')();
        preg_match_all('!<p>(.*?)</p>!', $contents, $matches);
        $output .= $matches[1][0] ?? 'Unknown';
        break;
    case 'prime' :
        $start = $argv[2] ?? 9000;
        $end   = $argv[3] ?? 9999;
        $primes = $container->get('prime')((int) $start, (int) $end);
        foreach ($primes as $number) $output .= $number . ' ';
        break;
    case 'city' :
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
        } else {
            $city = $container->get('city')();
            $output .= "Random City Info:\n";
            $output .= var_export($city, TRUE);
        }
        break;
    default :
        $output = 'Usage: ' . basename(__FILE__)
            . ' ntp|ipsum|prime|city [start] [end]'
            . PHP_EOL;
}
echo $output . PHP_EOL;
