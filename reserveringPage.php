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

            <form action="mqtt_send.php" method="POST">
                <label for="dag">Selecteer een Dag:</label>
                <input type="date" id="dag" name="dag" required><br><br>

                <label for="tijd">Selecteer een Tijd (24-uur formaat):</label>
                <input type="time" id="tijd" name="tijd" required><br><br>

                <div class="select-container">
                    <div class="select-field">
                        <label for="locatie">Selecteer Locatie:</label>
                        <select id="locatie" name="locatie" required>
                            <option value="EIN"> Eindhoven</option>
                            <option value="TIL"> Tilburg</option>
                        </select>
                    </div>
                </div>

                <br><br><label for="naam">Voornaam:</label>
                <input type="text" id="voornaam" name="voornaam" required>

                <label for="naam">Achternaam:</label>
                <input type="text" id="naam" name="achternaam" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <button type="submit">Reserveren</button>
            </form>

        </div>
    </section>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Parkeerplaats Reserveren. Alle rechten voorbehouden.</p>
    </footer>

</body>

</html>