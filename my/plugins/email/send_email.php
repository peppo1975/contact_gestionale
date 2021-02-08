<?php

require __DIR__ . '/PHPMailer-5.2-stable/PHPMailerAutoload.php';

include __DIR__ . '/controller_send_email.php';

$send_email = new SendEMail();

$email_settings = $send_email->email_settings();

$mail = new PHPMailer;


$html_message = "";
$email_send = "";
$subject = "";
$res = array();
/* * ***************************************** */
$to_send = $_POST;
$email_send = $to_send['email'];
$page = $to_send['page'] . ".php";
include __DIR__ . "/pages/{$page}";

/* * ***************************************** */


//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $email_settings['host'];  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $email_settings['username'];                 // SMTP username
$mail->Password = $email_settings['password'];                     // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = $email_settings['port'];                                 // TCP port to connect to

$mail->setFrom($email_settings['username'], 'Alert scadenze');
$mail->addAddress($email_send, $email_send);     // Add a recipient



//$mail->addAddress('g_lagonigro@libero.it', 'Joe User');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional

//$mail->addReplyTo('info@example.com', 'Information');

// - copia conoscenza --------------------------------------------
//$mail->addCC('cc@example.com');

// - copia conoscenza nascosta -----------------------------------
//$mail->addBCC('g_lagonigro@libero.it');
//$mail->addBCC('giuseppelag.curric@gmail.com');
//$mail->addBCC('bcc@example.com');

// - allegati ----------------------------------------------------
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//$mail->addAttachment('tmp/image.jpg', 'new.jpg');    // Optional name
//$mail->addAttachment('../../../dist/img/_site/email/test_allegato_1.jpg','all1.jpg');
//$mail->addAttachment("../../../dist/img/_site/email/test_allegato_2.jpg");
//$mail->addAttachment("../../../dist/img/_site/email/test_allegato_3.jpg");

if (isset($to_send['attachment']))
{

    $send_email->write_file("_to_send.txt", $to_send);

    foreach ($to_send['attachment'] as $attachment)
    {
        $mail->addAttachment($attachment);
    }
}


$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body = $html_message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send())
{
    $res['result_send']['text'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    $res['result_send']['value'] = 0;
//    echo ;
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
else
{
    $res['result_send']['text'] = 'Message has been sent';
    $res['result_send']['value'] = 1;
//    echo 'Message has been sent';
}

print json_encode($res);
