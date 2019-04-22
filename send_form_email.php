<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'mail.dpview.com.br';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'info@dpview.com.br';                     // SMTP username
    $mail->Password   = 'mkoZAQ09';                               // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->addAddress('reynier@dpview.com.br', 'Reynier');     // Add a recipient
    $mail->addReplyTo('info@dpview.com.br', 'Info');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML

    if(empty($_POST['first_name'])  || empty($_POST['email']) || empty($_POST['message']))
    {
        $errors = "\n Error: all fields are required";
    }

    if( empty($errors))
    {
        $mail->setFrom('info@dpview.com.br', 'Info');
        $mail->Subject = 'Contato via web: ';

        $sender= $_POST["first_name"];
        $sender .= " ";
        $sender .= $_POST["last_name"];
        $mail->Subject .= $sender;

        $senderEmail=$_POST["email"];
        $message=$_POST["message"];
        $mailBody="Name: $sender\nEmail: $senderEmail\n\n$message";

        $mail->Body = $mailBody;
        $mail->AltBody = "";
        if(!$mail->send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
        }
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
