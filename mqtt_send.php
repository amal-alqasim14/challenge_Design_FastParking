<?php
require 'mqtt_con.php';  // Importeer het verbindingsbestand
require 'db_con.php';

//Query om de hoogste id van de reserveringen op te halen
$query = "SELECT MAX(id) FROM Reserveringen";
$result = $mysqli->query($query);

// Controleer of de query succesvol was
if (!$result) {
    throw new Exception("Fout bij het uitvoeren van de query: " . $mysqli->error);
}

// Haal de eerste (en enige) kolom op (MAX(id))
$row = $result->fetch_row();
$maxId = $row[0]; // Dit is de maximale id

// Increment de id met 1
$reservering_id = $maxId + 1;

// Toon de nieuwe id
// echo "Volgende reservering ID: " . $reservering_id;


// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal het bericht op vanuit het formulier
    $dag = $_POST['dag'];
    $tijd = $_POST['tijd'];
    $locatie = $_POST['locatie'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    // Specificeer het onderwerp waarop je wilt publiceren
    $topic = "$locatie _ R";
    $bericht = "$reservering_id _ $dag _ $tijd _ $voornaam _ $achternaam _ $email";

    // // Verwijder eventuele spaties
    $topicZonderSpaties = str_replace(' ', '', $topic);
    $berichtZonderSpaties = str_replace(' ', '', $bericht);

    stuurMqttBericht("$topicZonderSpaties", $berichtZonderSpaties);

    // Bevestiging voor de gebruiker
    $confirmationMessage = "
     <div class='confirmation'>
         <h3>Bevestiging:</h3>
         <p>Reserverings-ID: $reservering_id</p>
         <p>Dag: $dag</p>
         <p>Tijd: $tijd</p>
         <p>Locatie: $locatie</p>
         <p>Voornaam: $voornaam</p>
         <p>Achternaam: $achternaam</p>
         <p>Email: $email</p>
         <p>Uw reservering is succesvol opgeslagen!</p>
     </div>";
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkeerplaats Reserveren</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>

    <!-- Header met Logo en Menu -->
    <header>
        <div class="logo">
        <a href="#home">
            <img src="image.png" alt="FastParking Logo" class="logo-img">
        </a>
            <h1>FastParking</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#reserveren">Reserveren</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Formulier voor Parkeerplaats Reserveren -->
    <section id="reserveren">
        <div class="card">
            <h2>Reserveer een Parkeerplaats</h2>

            <?php
            // Toon bevestiging of foutmelding na formulierverwerking
            if (isset($confirmationMessage)) {
                echo $confirmationMessage;
            } elseif (isset($errorMessage)) {
                echo "<div class='error'>$errorMessage</div>";
            }
            ?>

        </div>
    </section>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Parkeerplaats Reserveren. Alle rechten voorbehouden.</p>
    </footer>

</body>

</html