<?php
require 'vendor/bluerhinos/phpmqtt/phpMQTT.php'; 
require 'vendor/autoload.php';

// Nu kun je de phpMQTT klasse gebruiken
use Bluerhinos\phpMQTT;

// MQTT configuratie-instellingen
$host = '192.168.123.132';  // Voeg hier je MQTT broker adres in
$port = 1883;  
$clientId = 'client_' . uniqid();  // Voeg hier een unieke client-ID in
$username = 'mqtt_user';  
$password = 'Welkom123!';  


function stuurMqttBericht($topic, $bericht) {
    global $host, $port, $clientId, $username, $password;

    try {
        // Maak verbinding met de MQTT broker
        $mqtt = new phpMQTT($host, $port, $clientId);
        
        // Probeer verbinding te maken met de broker
        if ($mqtt->connect(true, NULL, $username, $password)) {
            // Als de verbinding succesvol is, publiceer het bericht
            $mqtt->publish($topic, $bericht, 0);
            $mqtt->close();  // Sluit de verbinding
            echo "Verbonden met MQTT en bericht verzonden!";
        } else {
            // Als de verbinding niet lukt, gooi een uitzondering
            throw new Exception("MQTT-verbinding mislukt.");
        }
    } catch (Exception $e) {
        // Als er een fout optreedt, log de foutmelding
        error_log("Fout bij verbinden met MQTT: " . $e->getMessage());
        echo "Er is een fout opgetreden: " . $e->getMessage();
    }
}

// Voorbeeld van het versturen van een bericht
// stuurMqttBericht("test/topic", "Hallo van MQTT!");
?>
