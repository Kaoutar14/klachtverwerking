<?php

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naam = trim($_POST['naam'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $klacht = trim($_POST['klacht'] ?? '');

    if ($naam === '' || $email === '' || $klacht === '') {

        $message = 'Vul alle velden in.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = 'Vul een geldig e-mailadres in.';

    } else {

        $mail = new PHPMailer(true);

        try {

            // SMTP instellingen
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = (int) $_ENV['MAIL_PORT'];

            // Afzender
            $mail->setFrom($_ENV['MAIL_FROM'], 'Klachtverwerking');

            // E-mail naar de gebruiker
            $mail->addAddress($email, $naam);

            // Jezelf in de cc
            $mail->addCC($_ENV['MAIL_CC']);


            // Onderwerp
            $mail->Subject = 'Uw klacht is in behandeling';

            // Bericht
            $mail->Body =
                "Beste $naam,\n\n" .
                "Uw klacht is in behandeling.\n\n" .
                "Naam: $naam\n" .
                "E-mail: $email\n" .
                "Klacht:\n$klacht\n\n" .
                "Met vriendelijke groet,\n" .
                "Klachtverwerking";

            // E-mail versturen
            $mail->send();

            $message = 'Uw klacht is verzonden.';

            } catch (Exception $e) {
                
                 $message = 'Fout: ' . $e->getMessage();

            }
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <title>Klachtverwerking</title>

</head>

<body>

    <h1>Klacht indienen</h1>

    <?php if ($message !== ''): ?>

        <p>
            <?= htmlspecialchars($message) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label for="naam">Naam:</label><br>

        <input
            type="text"
            id="naam"
            name="naam"
            required
        >

        <br><br>

        <label for="email">E-mail:</label><br>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <br><br>

        <label for="klacht">Omschrijving klacht:</label><br>

        <textarea
            id="klacht"
            name="klacht"
            rows="8"
            required
        ></textarea>

        <br><br>

        <button type="submit">
            Klacht versturen
        </button>

    </form>

</body>

</html>