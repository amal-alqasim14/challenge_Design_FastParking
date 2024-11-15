<?php
// Zet de foutmeldingen om in uitzonderingen
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database configuratie-instellingen
$DB_HOST = '192.168.123.31';  // Voer het IP-adres van de MySQL server in
$DB_USERNAME = 'mqtt_user';     // Voer de MySQL gebruikersnaam in
$DB_PASSWORD = 'Welkom123!';    // Voer het wachtwoord in voor de MySQL gebruiker
$DB_NAME = 'mqtt_data';         // Voer de naam van je database in

try {
    // Verbinden met de database (inclusief foutafhandelingsmechanisme)
    $mysqli = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    // Als je hier komt, is de verbinding succesvol
    echo "Verbonden met de database!";
    
    // Indien de verbinding succesvol is, kun je verdergaan met je code
    
} catch (mysqli_sql_exception $e) {
    // Fout afhandelen
    echo "DB Verbinding mislukt: " . $e->getMessage();
}
?>
