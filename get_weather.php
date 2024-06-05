<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $apiKey = $_ENV['WEATHER_API_KEY'];
    $apiUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$lat},{$lng}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['current'])) {
            $location = $data['location']['name'] . ", " . $data['location']['region'] . ", " . $data['location']['country'];
            $temperature = $data['current']['temp_c'] . "°C";
            $condition = $data['current']['condition']['text'];
            $humidity = $data['current']['humidity'] . "%";
            $windSpeed = $data['current']['wind_kph'] . " kph";
            $iconUrl = $data['current']['condition']['icon'];
            $tempfarenheit = $data['current']['temp_f'] . "F";
            $feelslike = $data['current']['feelslike_c'] . "°C";
            $winddir= $data['current']['wind_dir'];
            $heat= $data['current']['heatindex_c'] . "°C";

            $result = array(
                "location" => $location,
                "temperature" => $temperature,
                "condition" => $condition,
                "humidity" => $humidity,
                "windSpeed" => $windSpeed,
                "iconUrl"=>$iconUrl,
                "tempfarenheit"=>$tempfarenheit,
                "feelslike"=>$feelslike,
                "winddir"=>$winddir,
                "heat"=>$heat,
            );

            echo json_encode($result); // Encode the result as JSON
        } else {
            echo json_encode(array("error" => "Weather data not available"));
        }
    } else {
        echo json_encode(array("error" => "Unable to fetch data"));
    }
} else {
    echo json_encode(array("error" => "Invalid parameters"));
}
?>
