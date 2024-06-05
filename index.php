<!DOCTYPE html>
<html>
<head>
    <title>Weather Information</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>

<div class="clouds">
    <div class="animation black">
        <div class="cloud cloud1"></div>
        <div class="cloud cloud2"></div>
        <div class="cloud cloud3"></div>
    </div>
    <div class="container">
        <h2>Weather Wisdom at Your Fingertips!</h2>
        <div class="divider"></div>
        <p>Great things happen to those who don't stop believing, trying, learning, and being grateful.</p>
        <button class="btn">SkyInsight!</button>
    </div>
</div>

<div class="options">
    <button class="opt opt1"></button>
    <button class="opt opt2"></button>
    <button class="opt opt3"></button>
    <button class="opt opt4"></button>
</div>

<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$apiKey = $_ENV['WEATHER_API_KEY'];
    $city = 'Noida';
    $apiUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$city}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $weatherData = json_decode($response, true);

        if (isset($weatherData['error'])) {
            $location = 'Noida';
            $temperature = 'N/A';
            $condition = 'N/A';
            $humidity = 'N/A';
            $windSpeed = 'N/A';
            $lastUpdated = 'N/A';
        } else {
            $location = $weatherData['location']['name'] . ", " . $weatherData['location']['region'] . ", " . $weatherData['location']['country'];
            $temperature = $weatherData['current']['temp_c'] . "°C";
            $condition = $weatherData['current']['condition']['text'];
            $humidity = $weatherData['current']['humidity'] . "%";
            $windSpeed = $weatherData['current']['wind_kph'] . " kph";
            $lastUpdated = $weatherData['current']['last_updated'];
        }
    } else {
        $location = 'Noida';
        $temperature = 'N/A';
        $condition = 'N/A';
        $humidity = 'N/A';
        $windSpeed = 'N/A';
        $lastUpdated = 'N/A';
    }
?>

<div class="myloc">
    <h1 class="noida"><?php echo $location; ?></h1>
    <div class="flexx date_last">
        <h4><?php echo date('l, Y-m-d'); ?></h4>
        
        <!-- Display the last updated time -->
        <h4>Last updated: <?php echo date('H:i', strtotime($lastUpdated)); ?></h4>
    </div>
    <div class="box">
        <div class="flexx upperdiv">
            <div class="flexx div1">
                <i class="fa-solid fa-temperature-three-quarters"></i>
                <h4>Temperature</h4>
                <h5 class="info"><?php echo $temperature; ?></h5>
            </div>
            <div class="flexx div2">
                <i class="fa-regular fa-snowflake"></i>
                <h4>Condition</h4>
                <h5 class="info"><?php echo $condition; ?></h5>
            </div>
        </div>
        <div class="flexx lowerdiv">
            <div class="flexx div1">
                <i class="fa-solid fa-wind"></i>
                <h4>Wind</h4>
                <h5 class="info"><?php echo $windSpeed; ?></h5>
            </div>
            <div class="flexx div2">
                <i class="fa-solid fa-temperature-three-quarters"></i>
                <h4>Humidity</h4>
                <h5 class="info"><?php echo $humidity; ?></h5>
            </div>
        </div>
    </div>
</div>


<div class="mybtns flexx">
    <h2 class="neon">Eager to find out your local weather? Click here!</h2>
    <div class="flexx btn-gap">

        <div class="flexx btn-gap-2">
            
           
        <form action="location.php" method="get">
                <button class="btn-loc" type="submit">
                    <span class="icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <span class="text-big">Enter Location</span>
                </button>
        </form>
        </div>
        <div class="flexx">
            
            
        <form action="map.html" method="get">
            <button class="btn-loc" type="submit">
                <span class="icon">
                    <i class="fa-solid fa-map-pin"></i>
                </span>
                <span class="text-big">Locate On Map</span>
            </button>
        </form>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
