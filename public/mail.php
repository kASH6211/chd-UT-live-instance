<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);





$mail->CharSet = 'UTF-8';



try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = "relay.nic.in";    // SMTP server example
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
//    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 25;                    // set the SMTP port for the GMAIL server\
    //$mail->SMTPSecure = "tls";
    $mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false; 

    $mail->Username   = 'nextgen-dise@nic.in';
    $mail->Password   = 'Nextgendise@2023';                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('nextgen-dise@nic.in', 'Mailer');
    // $mail->addAddress('pwrda2022@gmail.com', 'Joe User');     //Add a recipient
    $mail->addAddress('pwrda2022@gmail.com', 'Joe User');     //Add a recipient


    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
