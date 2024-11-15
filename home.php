<?php
// Inclusie van db.php en mqtt.php voor database- en MQTT-verbindingen
include 'db_con.php';
include 'mqtt_con.php';
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkeerplaats Reserveren - Home</title>
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

    <!-- Homepage Sectie met Achtergrond en Knoppen -->
    <section id="home" class="homepage">
        <div class="background">
            <div class="buttons">
                <a href="reserveringPage.php" class="button">Reserveer een Parkeerplaats</a>
                <a href="vindmijnauto.php" class="button">Vind mijn Auto</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="homepage_footer">
        <p>&copy; 2024 Parkeerplaats Reserveren. Alle rechten voorbehouden.</p>
    </footer>

</body>

</html>
