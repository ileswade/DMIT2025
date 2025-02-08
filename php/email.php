<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$smtp_server = "smtp.gmail.com";
$port = 587;  // For TLS
$sender_email = "dmit2025email@gmail.com";
$password = "uyupjhrtguhpexgl";
$receiver_email = "ileswade@gmail.com";
$subject = "Test Email";
$body = "This is a test email sent from PHP Docker.";

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
    $mail->isSMTP();                      // Send using SMTP
    $mail->Host       = $smtp_server;     // Set the SMTP server
    $mail->SMTPAuth   = true;             // Enable SMTP authentication
    $mail->Username   = $sender_email;    // SMTP username
    $mail->Password   = $password;        // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
    $mail->Port       = $port;            // TCP port to connect to

    // Recipients
    $mail->setFrom($sender_email);
    $mail->addAddress($receiver_email);

    // Content
    $mail->isHTML(false);                 // Set email format to plain text
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    echo "Email sent successfully!";
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>