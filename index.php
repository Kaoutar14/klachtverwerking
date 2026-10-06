<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $klacht = $_POST["klacht"];

    echo "<h2>Je klacht is ontvangen!</h2>";
    echo "<p>Naam: " . htmlspecialchars($naam) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Klacht: " . htmlspecialchars($klacht) . "</p>";
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klacht indienen</title>
</head>
<body>

    <h1>Klacht indienen</h1>

    <form method="POST">

        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" required>
        <br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="klacht">Omschrijving klacht:</label><br>
        <textarea id="klacht" name="klacht" rows="8" cols="50" required></textarea>
        <br><br>

        <button type="submit">Klacht versturen</button>

    </form>

</body>
</html>
