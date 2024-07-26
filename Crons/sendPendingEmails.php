<?php

//require 'vendor/autoload.php'; // Include Composer's autoloader
require_once(realpath(__DIR__ . '/../mailer/src/Exception.php'));
require_once(realpath(__DIR__ . '/../mailer/src/PHPMailer.php'));
require_once(realpath(__DIR__ . '/../mailer/src/SMTP.php'));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database configuration
$host = 'localhost:3306';
$dbname = 'your_database';
$username = 'root';
$password = 'rootmysql';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Query to get unsent emails
$query = "SELECT * FROM EmailNotifications WHERE sent = false";
$stmt = $pdo->prepare($query);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($emails as $email) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // SMTP username
        $mail->Password = 'your_email_password'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($email['recipient_email']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $email['subject'];
        $mail->Body = $email['body'];

        // Send the email
        $mail->send();

        // Update the status to sent
        $updateQuery = "UPDATE EmailNotifications SET sent = true, sent_at = NOW() WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':id', $email['id']);
        $updateStmt->execute();

        echo "Email sent successfully to " . $email['recipient_email'] . "\n";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
    }
}
?>
