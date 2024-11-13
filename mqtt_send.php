<?php
require 'mqtt.php';  // Importeer het verbindingsbestand

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal het bericht op vanuit het formulier
    $message = $_POST['message'];

    // Specificeer het onderwerp waarop je wilt publiceren
    $topic = "test/topic";

    // Verstuur het bericht naar de MQTT-broker
    stuurMqttBericht($topic, $message);
}
?>
