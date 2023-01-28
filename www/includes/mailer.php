<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/Exception.php";

class Mailer {
    protected PHPMailer $mailer;


    public function __construct() {
        /* Get settings from settings file */
        $settings = (include("settings.php"))->mailer;

        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();                                  //Send using SMTP
        $this->mailer->SMTPAuth   = true;                         //Enable SMTP authentication
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $this->mailer->Host       = $settings["host"];            //Set the SMTP server to send through
        $this->mailer->Port       = $settings["port"];            
        $this->mailer->Username   = $settings["username"];        //SMTP username
        $this->mailer->Password   = $settings["password"];        //SMTP password
    }

    public function sendMail($recipient, $subject, $body, $altbody=Null) {
        $this->mailer->setFrom('eureka@endr.nl', 'Eureka - OpenCDX');
        $this->mailer->addAddress($recipient);

        if ($altbody != Null) {
            $this->mailer->isHTML(true); 
            $this->mailer->AltBody = $altbody;
        } else {
            $this->mailer->isHTML(false); 
        }
        $this->mailer->Subject = $subject;
        $this->mailer->Body    = $body;

        $this->mailer->send();
    }
}
?>