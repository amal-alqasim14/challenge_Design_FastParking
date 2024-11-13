<?php
require 'phpMQTT.php';  // Verwijs naar de juiste locatie van phpMQTT

// MQTT configuratie-instellingen
$host = 'mqtt-broker-adres';  // Voeg hier je MQTT broker adres in
$port = 1883;  // Voeg hier de poort in, bijv. 1883 voor niet-beveiligde verbinding
$clientId = 'php_mqtt_client';  // Voeg hier een client-ID in
$username = 'mqtt_user';  // Voeg hier de gebruikersnaam in
$password = 'mqtt_password';  // Voeg hier het wachtwoord in

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
