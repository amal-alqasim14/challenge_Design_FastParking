<?php

// Configuratie-instellingen
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USERNAME') ?: 'mqtt_user';
$password = getenv('DB_PASSWORD') ?: 'Welkom123!';
$dbname = getenv('DB_NAME') ?: 'mqtt_data';

try {
    // Maak verbinding met de database via PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Verbinding met de database mislukt.";
    error_log("Databasefout: " . $e->getMessage());
    exit();
}
?>
