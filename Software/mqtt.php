<?php
require 'phpMQTT.php';  // Verwijs naar de juiste locatie van phpMQTT

// MQTT configuratie-instellingen
$host = getenv('MQTT_BROKER_HOST') ?: 'mqtt-broker-adres';
$port = getenv('MQTT_BROKER_PORT') ?: 1883;
$clientId = getenv('MQTT_CLIENT_ID') ?: 'php_mqtt_client';
$username = getenv('MQTT_USERNAME') ?: 'mqtt_user';
$password = getenv('MQTT_PASSWORD') ?: 'mqtt_password';

// Functie om een bericht naar de MQTT-broker te sturen
function stuurMqttBericht($topic, $bericht) {
    global $host, $port, $clientId, $username, $password;
    $mqtt = new phpMQTT($host, $port, $clientId);

    if ($mqtt->connect(true, NULL, $username, $password)) {
        $mqtt->publish($topic, $bericht, 0);
        $mqtt->close();
    } else {
        error_log("MQTT-verbinding mislukt.");
    }
}
?>
