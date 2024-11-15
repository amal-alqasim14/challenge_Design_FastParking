<?php
// Inclusie van db.php en mqtt.php voor database- en MQTT-verbindingen
include 'db.php';
include 'mqtt.php';

// Verwerk het formulier als het is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verzamel de gegevens van het formulier
    $dag = $_POST['dag'];
    $tijd = $_POST['tijd'];
    $locatie = $_POST['locatie'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    try {
        // SQL-insert-query
        $sql = "INSERT INTO Reserveringen (locatie, dag, tijd, voornaam, achternaam, email) 
                VALUES (:locatie, :dag, :tijd, :voornaam, :achternaam, :email)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dag', $dag);
        $stmt->bindParam(':tijd', $tijd);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':voornaam', $voornaam);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':email', $email);

        // Voer de insert-query uit
        $stmt->execute();

        // Selecteer de reservering_id van de zojuist toegevoegde reservering
        $sql = "SELECT reservering_id FROM Reserveringen 
                WHERE locatie = :locatie AND dag = :dag AND tijd = :tijd 
                  AND voornaam = :voornaam AND achternaam = :achternaam AND email = :email
                ORDER BY reservering_id DESC LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':dag', $dag);
        $stmt->bindParam(':tijd', $tijd);
        $stmt->bindParam(':voornaam', $voornaam);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':email', $email);

        // Voer de select-query uit
        $stmt->execute();

        // Haal het reservering_id op uit de resultaten
        $reservering_id = $stmt->fetchColumn();

        if ($reservering_id) {
            echo "Reservering succesvol! ID: " . $reservering_id;
        } else {
            echo "Reservering niet gevonden.";
        }

    } catch (PDOException $e) {
        $errorMessage = "Fout bij invoeren van gegevens: " . $e->getMessage();
        echo $errorMessage;
    }
}
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkeerplaats Reserveren</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Header met Logo en Menu -->
    <header>
        <div class="logo">
            <H1>FastParking</H1>
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