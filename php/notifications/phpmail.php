<?php
require 'PHPMailer/PHPMailerAutoload.php';

function sendMail($email,$subject, $bodyContent, $sender)
{
    $mail = new PHPMailer;
    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                            // Enable SMTP authentication
    $mail->Username = 'yurekahighereducation@gmail.com';          // SMTP username
    $mail->Password = 'yurekaofficial';            // SMTP password
    $mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                 // TCP port to connect to

    $mail->setFrom('yurekahighereducation@gmail.com', 'Yureka Institute');
    $mail->addReplyTo('yurekahighereducation@gmail.com', 'Yureka Institute');
    $mail->addAddress($email);   // Add a recipient
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    $mail->isHTML(true);  // Set email format to HTML


    $mail->Subject = $subject." " .$sender;
    $mail->Body = $bodyContent;

    $mail->send();
}

?>


		