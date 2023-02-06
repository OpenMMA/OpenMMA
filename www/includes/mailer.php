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
        $settings = (object)(include("settings.php"))->mailer;

        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();                                  //Send using SMTP
        $this->mailer->SMTPAuth   = true;                         //Enable SMTP authentication
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $this->mailer->Host       = $settings->host;              //Set the SMTP server to send through
        $this->mailer->Port       = $settings->port;              
        $this->mailer->Username   = $settings->username;          //SMTP username
        $this->mailer->Password   = $settings->password;          //SMTP password
    }

    public function sendMail($recipient, $subject, $body, $altbody=Null) {
        try {
            echo "a\n";
            $this->mailer->setFrom('eureka@endr.nl', 'Eureka - OpenCDX');
            $this->mailer->addAddress($recipient);

            echo "b\n";
            
            if ($altbody != Null) {
                $this->mailer->isHTML(true); 
                $this->mailer->AltBody = $altbody;
            } else {
                $this->mailer->isHTML(false); 
            }
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            echo "c\n";
            
            $this->mailer->send();
            echo "d\n";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
?>