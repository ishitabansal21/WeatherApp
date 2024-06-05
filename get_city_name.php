<?php
if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $apiUrl = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}&addressdetails=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['address']['city'])) {
            echo $data['address']['city'];
        } elseif (isset($data['address']['town'])) {
            echo $data['address']['town'];
        } elseif (isset($data['address']['village'])) {
            echo $data['address']['village'];
        } else {
            echo 'City not found';
        }
    } else {
        echo 'Error: Unable to fetch data';
    }
} else {
    echo 'Error: Invalid parameters';
}
?>
