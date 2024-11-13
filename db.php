<?php
// Database configuratie-instellingen
$DB_HOST = 'localhost';  // Voer het database hostadres in
$DB_USERNAME = 'mqtt_user';  // Voeg de gebruikersnaam in
$DB_PASSWORD = 'Welkom123!';  // Voeg het wachtwoord in
$DB_NAME = 'mqtt_data';  // Voeg de naam van je database in

// Verbinden met de database
$mysqli = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die("Verbinding mislukt: " . $mysqli->connect_error);
}
?>
