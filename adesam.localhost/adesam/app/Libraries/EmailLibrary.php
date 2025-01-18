<?php

namespace App\Libraries;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * 
 */
class EmailLibrary
{

    protected $username = 'wunmiji@gmail.com';
    protected $password = 'laqc hykr uvzl aoxu';
    public $subject;
    public $from;
    public $fromName;
    public $to;
    public $message;

    function setSubject($subject)
    {
        $this->subject = $subject;
    }

    function setFrom($from, $name = '')
    {
        $this->from = $from;
        $this->fromName = $name;
    }

    function setTo($to)
    {
        $this->to = $to;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = $this->username;                     //SMTP username
        $mail->Password = $this->password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_SMTPS ENCRYPTION_STARTTLS'
        
        //Recipients
        $mail->setFrom($this->from, $this->fromName);
        $mail->addAddress($this->to);
        //$mail->addReplyTo($email, $name);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $this->subject;
        $mail->Body = $this->message;

        return $mail->send();
    }

}