<?php
namespace Content\PHPMailer;

use Content\PHPMailer\PHPMailer;
use Content\PHPMailer\SMTP;
use Content\PHPMailer\Exception;

class SendMail
{
    protected $result;
	
	public function send($pochta,$text_pisma,$zagolovok,$imia) 
	{
     //Create an instance; passing `true` enables exceptions
     $mail = new PHPMailer(true);

    try {
     //Server settings
     //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = '';                     //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = '';                     //SMTP username
     $mail->Password   = '';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

     //Recipients 
     $mail->setFrom('');         // Адрес самой почты и имя отправителя
     $mail->addAddress($pochta, $imia);                     // Получатель письма
     //$mail->addAddress('ellen@example.com');               //Name is optional
     $mail->addReplyTo('');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');

     //Attachments
     //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

     //Content
     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = $zagolovok;
     $mail->Body    = $text_pisma;
     //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

     $mail->send();

    } catch (Exception $e) {
         $this->result = "Сообщение не было отправлено. Ошибка при отправке письма. Причина ошибки: {$mail->ErrorInfo}";
        }
     return $this->result;
	}
}
