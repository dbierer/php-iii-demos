<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Ntp\Client;
use App\Lorem\Ipsum;
use App\Number\Prime;
use App\Weather\Forecast;
use App\Geonames\{Random,Build};

$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) {

    // init vars
    $quit   = TRUE;
    $start  = microtime(TRUE);
    $params = $request->getQueryParams();
    $action = $params['action'] ?? '';
    $output = '';
    switch ($action) {
        case 'ntp' :
            // NTP request
            $error  = [];
            $client = new Client();
            $output .= "NTP Time:\n";
            $output .= var_export($client->getTime($error), TRUE);
            break;
        case 'ipsum' :
            $output .= "Lorem Ipsum:\n";
            $contents = Ipsum::getHtml();
            preg_match_all('!<p>(.*?)</p>!', $contents, $matches);
            $output .= $matches[1][0] ?? 'Unknown';
            break;
        case 'prime' :
            $start = rand(1,9) * 1000;
            $end   = $start + 1000;
            $primes = Prime::generate($start, $end);
            foreach ($primes as $number) $output .= $number . ' ';
            break;
        case 'weather' :
            // Pick random city
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
            break;
        default :
            $quit = FALSE;
    }
    if ($quit) {
        // report elapsed time
        $output .= "\n\n<br />Elapsed Time: " . (microtime(TRUE) - $start) . "\n";
    }

    return React\Http\Message\Response::plaintext($output);

});

$socket = new React\Socket\SocketServer('127.0.0.1:8222');
$http->listen($socket);

echo "Server running at http://127.0.0.1:8222" . PHP_EOL;
