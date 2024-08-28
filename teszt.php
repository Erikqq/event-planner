<?php
require 'email.php';

// Email details
$to = 'pecsierik02@gmail.com';
$subject = 'Test Email';
$body = '<p>This is a test email sent using PHPMailer.</p>';

// Send the email
sendEmail($to, $subject, $body);
?>
