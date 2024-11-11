<?php
// Database configuratie
$servername = "localhost";  // Database host
$username = "root";         // Database gebruiker
$password = "";             // Database wachtwoord
$dbname = "parkeren";       // Database naam

// Maak verbinding met de database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Stel de PDO-foutmodus in
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Verbonden met de database!";
} catch(PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}
?>
