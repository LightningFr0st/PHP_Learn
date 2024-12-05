<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            text-align: center;
        }
    </style>
</head>
<body>
<form method="post">
    <label for="city">Введите город:</label>
    <input type="text" id="city" name="city" style="width: 500px" value="Минск" required>
    <br><br>
    <button type="submit">Погода</button>
</form>

</body>
</html>


<?php

$lat = 0;
$lon = 0;

if (isset($_POST['city'])) {
    displayWeatherTable($_POST['city']);
}
function openweather($city): array
{
    $url = "http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid=$token";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    global $lat;
    global $lon;

    if (!$response) {
        echo curl_error($ch);
    } else {
        $response = json_decode($response, true);
        $lat = $response[0]['lat'];
        $lon = $response[0]['lon'];
    }
    $url = "api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&cnt=9&lang=ru&units=metric&appid=$token";
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    if (!$response) {
        $result = null;
        echo curl_error($ch);
    } else {
        $response = json_decode($response, true);
        $result = [
            'temp' => $response['list'][8]['main']['temp'],
            'humidity' => $response['list'][8]['main']['humidity'],
            'pressure' => $response['list'][8]['main']['pressure'],
            'cloudiness' => $response['list'][8]['clouds']['all'],
            'description' => $response['list'][8]['weather'][0]['description'],
            'pops' => (array_key_exists('rain', $response['list'][8]) ? $response['list'][8]['rain']['3h'] : 0),
            'wind' => $response['list'][8]['wind']['speed']
        ];
    }
    curl_close($ch);
    return $result;
}

function weatherapi(): array
{
    global $lat;
    global $lon;
    $url = "http://api.weatherapi.com/v1/forecast.json?key=$token&q=$lat,$lon&days=2&lang=ru";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);


    if (!$response) {
        echo curl_error($ch);
        $result = null;
    } else {
        $response = json_decode($response, true);
        $result = [
            'temp' => $response['forecast']['forecastday'][1]['day']['avgtemp_c'],
            'humidity' => $response['forecast']['forecastday'][1]['day']['avghumidity'],
            'pressure' => $response['forecast']['forecastday'][1]['hour']['12']['pressure_mb'],
            'cloudiness' => $response['forecast']['forecastday'][1]['hour']['12']['cloud'],
            'description' => $response['forecast']['forecastday'][1]['day']['condition']['text'],
            'pops' => $response['forecast']['forecastday'][1]['day']['totalprecip_mm'],
            'wind' => round($response['forecast']['forecastday'][1]['day']['maxwind_kph'] * 1000 / 3600, 2),
        ];
    }
    return $result;
}

function meteostat(): array
{
    global $lat;
    global $lon;
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://meteostat.p.rapidapi.com/point/daily?lat=$lat&lon=$lon",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        $result = null;
    } else {
        $response = json_decode($response, true);
        $result = [
            'temp' => $response['data']['1']['tavg'],
            'pressure' => $response['data']['1']['pres'],
            'pops' => $response['data']['1']['prcp'],
            'wind' => round($response['data']['1']['wspd'] * 1000 / 3600, 2)
        ];
    }
    return $result;
}

function apininjas(): array
{
    global $lon;
    global $lat;
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://weather-by-api-ninjas.p.rapidapi.com/v1/weather?lat=$lat&lon=$lon",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        $result = null;
    } else {
        $response = json_decode($response, true);
        $result = [
            'temp' => $response['temp'],
            'humidity' => $response['humidity'],
            'cloudiness' => $response['cloud_pct'],
            'wind' => round($response['wind_speed'] * 1000 / 3600, 2),
        ];
    }
    return $result;
}

function forecastapi(): array
{
    global $lat;
    global $lon;
    $curl = curl_init();
    $lat = round($lat, 2);
    $lon = round($lon, 2);
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://forecast9.p.rapidapi.com/rapidapi/forecast/$lat/$lon/summary/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        $result = null;
    } else {
        $response = json_decode($response, true);
        $result = [
            'temp' => $response['items'][1]['temperature']['max'],
            'pops' => $response['items'][1]['prec']['probability'],
            'wind' => round($response['items'][1]['wind']['max'] * 1000 / 3600, 2),
        ];
    }
    return $result;
}

function calculateAverage($values): float
{
    return round(array_sum($values) / count($values), 2);
}

function displayWeatherTable($city): void
{
    $weatherData = [
        'OpenWeather' => openweather($city),
        'WeatherApi' => weatherapi(),
        'Meteostat' => meteostat(),
        'API-Ninjas' => apininjas(),
        'ForecastApi' => forecastapi(),
    ];
    $averages = [
        'temp' => calculateAverage(array_column($weatherData, 'temp')),
        'humidity' => calculateAverage(array_column($weatherData, 'humidity')),
        'pressure' => calculateAverage(array_column($weatherData, 'pressure')),
        'cloudiness' => calculateAverage(array_column($weatherData, 'cloudiness')),
        'pops' => calculateAverage(array_column($weatherData, 'pops')),
        'wind' => calculateAverage(array_column($weatherData, 'wind'))
    ];

    echo "<table>";
    echo "<header>";
    echo "<td>Источник</td>";
    echo "<td>Температура, С</td>";
    echo "<td>Влажность, %</td>";
    echo "<td>Давление, кПа</td>";
    echo "<td>Облачность, %</td>";
    echo "<td>Осадки, мм</td>";
    echo "<td>Скорость ветра, м/c</td>";
    echo "<td>Описание</td>";
    echo "</header>";


    foreach ($weatherData as $source => $data) {
        echo "<tr>";
        echo "<td>$source</td>";
        cellInfo($data, 'temp');
        cellInfo($data, 'humidity');
        cellInfo($data, 'pressure');
        cellInfo($data, 'cloudiness');
        cellInfo($data, 'pops');
        cellInfo($data, 'wind');
        cellInfo($data, 'description');
        echo "</tr>";
    }

    echo "<tr><th>Average</th>";
    echo "<th>" . $averages['temp'] . "</th>";
    echo "<th>" . $averages['humidity'] . "</th>";
    echo "<th>" . $averages['pressure'] . "</th>";
    echo "<th>" . $averages['cloudiness'] . "</th>";
    echo "<th>" . ($averages['pops']) . "</th>";
    echo "<th>" . ($averages['wind']) . "</th>";
    echo "<th> — </th>";
    echo "</tr>";
    echo "</table>";
}

function cellInfo(&$arr, $key)
{
    if (array_key_exists($key, $arr)) {
        echo "<td>" . $arr[$key] . "</td>";
    } else {
        echo "<td> — </td>";
    }
}

?>


