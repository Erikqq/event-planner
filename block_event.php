<?php
require("db_config.php");
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['block_event'])) {
    $eventId = $_POST['event_id'];

    // Retrieve event details
    $eventQuery = "SELECT * FROM events WHERE id = '$eventId'";
    $eventResult = mysqli_query($con, $eventQuery);
    $event = mysqli_fetch_assoc($eventResult);

    if ($event) {
        // Retrieve organizer's email address
        $userId = $event['user_id'];
        $userQuery = "SELECT email FROM users WHERE id = '$userId'";
        $userResult = mysqli_query($con, $userQuery);
        $user = mysqli_fetch_assoc($userResult);
        $email = $user['email'];

        // Insert event into blocked_events table
        $query = "INSERT INTO blocked_events (user_id, name, event_date, place, type, comment, created_at)
                  VALUES ('{$event['user_id']}', '{$event['name']}', '{$event['event_date']}', '{$event['place']}', '{$event['type']}', '{$event['comment']}', '{$event['created_at']}')";
        mysqli_query($con, $query);

        // Delete the event from the events table
        $deleteQuery = "DELETE FROM events WHERE id = '$eventId'";
        mysqli_query($con, $deleteQuery);


        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'mail.void.stud.vts.su.ac.rs';
            $mail->SMTPAuth = true;
            $mail->Username = 'void';
            $mail->Password = 'n3cQPMl19XdpPt7';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('void@void.stud.vts.su.ac.rs', 'Esemény szervező');
            $mail->addAddress($email);
            $mail->Subject = 'Esemény betiltva';
            $mail->Body    = 'Sajnáljuk, de az alábbi eseményt betiltottuk: ' .
                             'Név: ' . $event['name'] . "\n" .
                             'Dátum: ' . $event['event_date'] . "\n" .
                             'Helyszín: ' . $event['place'] . "\n" .
                             'Típus: ' . $event['type'] . "\n" .
                             'Kommentár: ' . $event['comment'] . "\n\n" .
                             'Ha kérdései vannak, kérjük lépjen kapcsolatba velünk.';

            $mail->send();
            echo "Esemény sikeresen betiltva és az email elküldve.";
        } catch (Exception $e) {
            echo "Hiba történt az email küldése során: " . $mail->ErrorInfo;
        }
    } else {
        echo "Az esemény nem található.";
    }
} else {
    echo "Nincs kiválasztott esemény.";
}
header("Location: manage_events.php");
?>
