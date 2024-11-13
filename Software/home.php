<?php
// Inclusie van db.php voor de databaseverbinding
// include 'db.php';

// Verwerk het formulier als het is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verzamel de gegevens van het formulier
    $dag = $_POST['dag'];
    $tijd = $_POST['tijd'];
    $verdieping = $_POST['verdieping'];
    $locatie = $_POST['locatie'];  // Locatie ophalen
    $naam = $_POST['naam'];
    $email = $_POST['email'];

    // Invoegen van gegevens in de database
    try {
        // Maak de SQL-insert-query
        $sql = "INSERT INTO reserveringen (dag, tijd, verdieping, locatie, naam, email) 
                VALUES (:dag, :tijd, :verdieping, :locatie, :naam, :email)";
        
        // Bereid de query voor
        $stmt = $conn->prepare($sql);

        // Bind de waarden aan de query
        $stmt->bindParam(':dag', $dag);
        $stmt->bindParam(':tijd', $tijd);
        $stmt->bindParam(':verdieping', $verdieping);
        $stmt->bindParam(':locatie', $locatie);  // Locatie binden
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);

        // Voer de query uit
        $stmt->execute();

        echo "<div class='confirmation'>
                <h3>Bevestiging:</h3>
                <p>Dag: $dag</p>
                <p>Tijd: $tijd</p>
                <p>Verdieping: $verdieping</p>
                <p>Locatie: $locatie</p>  <!-- Locatie tonen -->
                <p>Naam: $naam</p>
                <p>Email: $email</p>
                <p>Uw reservering is succesvol opgeslagen!</p>
              </div>";
    } catch(PDOException $e) {
        echo "Fout bij invoeren van gegevens: " . $e->getMessage();
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
        <form action="index.php" method="POST">
            <label for="dag">Selecteer een Dag:</label>
            <input type="date" id="dag" name="dag" required><br><br>

            <label for="tijd">Selecteer een Tijd (24-uur formaat):</label>
            <input type="time" id="tijd" name="tijd" required><br><br>

            <div class="select-container">
                <div class="select-field">
                    <label for="verdieping">Selecteer Verdiening:</label>
                    <select id="verdieping" name="verdieping" required>
                        <option value="verdieping1">Verdieping 1</option>
                        <option value="verdieping2">Verdieping 2</option>
                    </select>
                </div>

                <div class="select-field">
                    <label for="locatie">Selecteer Locatie:</label>
                    <select id="locatie" name="locatie" required>
                        <option value="locatieA">Locatie Eindhoven</option>
                        <option value="locatieB">Locatie Tilburg</option>
                        <option value="locatieC">Locatie Amsterdam</option>
                    </select>
                </div>
            </div>

            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" required><br><br>

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
