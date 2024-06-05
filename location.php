<!DOCTYPE html>
<html>
<head>
    <title>Weather Information</title>
    <link rel="stylesheet" href="location.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   
</head>
<body>
<div>




<?php
    // Include PHPMailer autoload file
    include ('smtp/PHPMailerAutoload.php');
    require 'vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    
    $location = "USA";
    $temperature = "24°C";
    $condition = "Cloudy";
    $iconUrl = "https://cdn.weatherapi.com/weather/64x64/day/116.png";
    $humidity = "65";
    $windSpeed = "3.6 kph";
    $lastUpdated = "1:06";
    $tempfarenheit = "75.2F";
    $feelslike = "25.6°C";
    $winddir="N";
    $heat="23.4°C";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $city = htmlspecialchars($_POST['city']);
        $email = htmlspecialchars($_POST['email']);
        $apiKey = $_ENV['WEATHER_API_KEY'];
        $apiUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$city}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $weatherData = json_decode($response, true);

            echo "<script>console.log(" . json_encode($weatherData) . ")</script>";

            if (isset($weatherData['error'])) {
                echo "<p>Error: " . $weatherData['error']['message'] . "</p>";
            } else {
                $location = $weatherData['location']['name'] . ", " . $weatherData['location']['region'] . ", " . $weatherData['location']['country'];
                $temperature = $weatherData['current']['temp_c'] . "°C";
                $condition = $weatherData['current']['condition']['text'];
                $iconUrl = $weatherData['current']['condition']['icon'];
                $humidity = $weatherData['current']['humidity'] . "%";
                $windSpeed = $weatherData['current']['wind_kph'] . " kp";
                $lastUpdated = $weatherData['current']['last_updated'];
                $tempfarenheit = $weatherData['current']['temp_f'] . "F";
                $feelslike = $weatherData['current']['feelslike_c'] . "°C";
                $winddir= $weatherData['current']['wind_dir'];
                $heat= $weatherData['current']['heatindex_c'] . "°C";

                // echo "<h3>Weather Information for $location</h3>";
                // echo "<p><strong>Temperature:</strong> $temperature</p>";
                // echo "<p><strong>Condition:</strong> <img src='$iconUrl' alt='$condition' /> $condition</p>";
                // echo "<p><strong>Humidity:</strong> $humidity</p>";
                // echo "<p><strong>Wind Speed:</strong> $windSpeed</p>";
                // echo "<p><strong>Last Updated:</strong> $lastUpdated</p>";



                $prompt = "Generated a detailed weather report for the $location with temperature $temperature, condition $condition, humidity $humidity, wind speed $windSpeed.";

                // $postData = [
                //     'prompt' => $prompt,
                //     'max_tokens' => 150,
                //     'temperature' => 0.7
                // ];

                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $openAiApiUrl);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                // curl_setopt($ch, CURLOPT_HTTPHEADER, [
                //     'Content-Type: application/json',
                //     'Authorization: Bearer ' . $openAiApiKey
                // ]);
                // $aiResponse = curl_exec($ch);
                // curl_close($ch);

                // if ($aiResponse) {
                //     $aiData = json_decode($aiResponse, true);
                //     if(isset($aiData['choices'][0]['text'])) {
                //         $aiEmailBody = $aiData['choices'][0]['text'];
                //     } else {
                //         $aiEmailBody = "No AI-generated content available.";
                //     }

                //     // Display the AI-generated quote
                //     echo "<p><strong>AI Generated Weather Report:</strong> $aiEmailBody</p>";

                    // Send email with PHPMailer
                    $mail = new PHPMailer();

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ishitabansal2102@gmail.com'; // Replace with your SMTP username
                    $mail->Password = 'pixbmzyfshimlwwd'; // Replace with your SMTP password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->From = 'ishitabansal2102@gmail.com'; // Replace with your sender email
                    $mail->FromName = 'Weather Info';
                    $mail->addAddress($email);  // Add the recipient's email
                    $mail->addReplyTo('info@example.com', 'Information');

                    $mail->isHTML(true);

                    $mail->Subject = "Weather Information for $location";
                    $mail->Body = $prompt;
                    $mail->AltBody = strip_tags($prompt);

                    if(!$mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        echo 'Weather information has been sent to your email.';
                    }
                } 
                
            }
        }
        // } else {
        //     echo "<p>Could not retrieve weather data. Please try again later.</p>";
        // }


    

    

?>

<script>
        function updateTemperature(unit) {
            // var temperatureElement = document.getElementById('temperatureDisplay');
            // var feelsLikeElement = document.getElementById('feelsLikeDisplay');
            var temperatureUnitElement = document.getElementById('temperature-unit');

            if (unit === 'fahrenheit') {
                temperatureUnitElement.textContent = '<?php echo $tempfarenheit; ?>';
               
            } else if (unit === 'feelslike') {
                temperatureUnitElement.textContent = '<?php echo $feelslike; ?>';
               
            } else {
                temperatureUnitElement.textContent = '<?php echo $temperature; ?>';
               
            }
        }
    </script>


    <div class="weather-container">
        <div class="left-section">
            <div class="weather-header">
                <div>
                    <form method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="last_div">

    <label for="city">Your city</label>
    
    <input type="text" id="city" name="city">
    <button class="button-17">Search</button><br>
</div>

                        <label for="email">Get Weather Report</label>
                            <input class="email_input"  type="email" id="email" name="email" placeholder="abc@gmail.com">
                        
                    </form>
                </div>
                <div class="weather-date">
                    <p><?php echo date('l, Y-m-d'); ?></p>
                    <p class="city">'<?php echo $location; ?>'</p>
                </div>
            </div>
            <div class="weather-info">
                <div class="weather-details">
                    <div class="flexx temp_img">
    
                       
                        <img class="imgsize" src="<?php echo $iconUrl; ?>" alt="Weather icon">

                        <p class="weather-temp" id="temperature-unit"><?php echo $temperature; ?></p>
                    </div>
                    <p class="weather-desc"><?php echo $condition; ?></p>
                </div>
            </div>
            <div class="weather-extra">
                <!-- <p><strong>Humidity:</strong> 45%</p>
                <p><strong>Wind speed:</strong> 19.2 km/j</p> -->
                <button class="button-55" onclick="updateTemperature('fahrenheit')">In Farenheit</button>
                <button class="button-55" onclick="updateTemperature('feelslike')"><span><i class="fa-regular fa-face-smile"></i></span>Feels Like</button>
            </div>
        </div>
        <div class="right-section">
        <div class="temperature-chart">
                <canvas id="temperatureChart" width="400" height="200"></canvas>
            </div>
            <div class="forecast-cards">
                <div class="forecast-card">
                    
                <div class="circle2"></div>
                <i class="ficon fa-solid fa-fire-flame-simple"></i>
                    <p class="ftext content">Humidity</p>
                    <p class="finfo"><?php echo $humidity; ?></p>
                </div>
                <div class="forecast-card">
                <div class="circle2"></div>
                <i class="ficon fa-solid fa-wind"></i>
                    <p class="ftext content">Wind Speed</p>
                    <p class="finfo"><?php echo $windSpeed; ?></p>
                </div>
                <div class="forecast-card">
                <div class="circle2"></div>
                    <i class="ficon fa-regular fa-compass"></i>
                    <p class="ftext content">Direction</p>
                    <p class="finfo"><?php echo $winddir; ?></p>
                </div>
                <div class="forecast-card">
                <div class="circle2"></div>
                <i class="ficon fa-solid fa-temperature-high"></i>
                    <p class="ftext content">Heat Index</p>
                    <p class="finfo"><?php echo $heat; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div>
    
    <h4>Last updated: <?php echo date('H:i', strtotime($lastUpdated)); ?></h4>
    </div>
</div>








<script>


document.addEventListener("DOMContentLoaded", function() {
    <?php
    // Extract numerical value from $temperature and convert it to a suitable format
    $temperatureValue = floatval($temperature); // Extract numerical value
    ?>
    const temperatureData = [<?php echo $temperatureValue; ?>]; // Convert to numerical value
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Temperature'],
            datasets: [{
                label: 'Temperature',
                data: temperatureData,
                backgroundColor: 'rgba(255, 192, 203, 0.6)', // Light pink background
                 borderColor: 'rgba(255, 192, 203, 1)', // Dark pink border
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // This makes the bar chart horizontal
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
});


</script>

</body>
</html>
