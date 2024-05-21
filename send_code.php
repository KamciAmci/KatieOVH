<?php
require 'system/PHPMailer/src/Exception.php';
require 'system/PHPMailer/src/PHPMailer.php';
require 'system/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generate_code() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function send_email($to_email, $code) {
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'pro3.mail.ovh.net'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'NoReply@katie.ovh';
        $mail->Password = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Odbiorca i nadawca
        $mail->setFrom('NoReply@katie.ovh', 'Katie.OVH');
        $mail->addAddress($to_email);

        // Treść wiadomości
        $mail->isHTML(true);
        $mail->Subject = 'Your 6 digit code';
        $mail->Body    = 'Your code is: ' . $code;

        $mail->send();
        echo 'Email sended succesfully!';
    } catch (Exception $e) {
        echo "Error while sending email: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $recipient_email = $_POST['email'];
    $code = generate_code();
    send_email($recipient_email, $code);
} else {
    echo "Please enter email in form.";
}
?>
