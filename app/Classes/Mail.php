<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enviar Correos
class Mail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host       =  $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   =  $_ENV['MAIL_ACCOUNT'];
        $this->mail->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = $_ENV['MAIL_STMP_PORT'];
        $this->mail->setFrom($_ENV['MAIL_FROM_EMAIL'],  $_ENV['MAIL_FROM_USERNAME']);
        $this->mail->addEmbeddedImage(__DIR__ . '/../../public/assets/images/logo.png', 'logo');
        $this->mail->addEmbeddedImage(__DIR__ . '/../../public/assets/images/facebook.png', 'facebook');
        $this->mail->addEmbeddedImage(__DIR__ . '/../../public/assets/images/instagram.png', 'instagram');
        $this->mail->addEmbeddedImage(__DIR__ . '/../../public/assets/images/linkedin.png', 'linkedin');
        $this->mail->addEmbeddedImage(__DIR__ . '/../../public/assets/images/twitter.png', 'twitter');
    }

    public function sendEmailContactTenant($contactDetails)
    {
        try {
            $this->mail->addAddress($contactDetails['email'], $contactDetails['name']);
            $this->mail->addCC($_ENV['MAIL_TO_EMAIL']);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Formulario de contacto inquilino';
            $body = file_get_contents(__DIR__ . '/../Templates/contactTenant.html');

            $email_vars = array(
                'name' => $contactDetails['name'],
                'email' => $contactDetails['email'],
                'phone' => $contactDetails['phone'],
                'countryCode' => $contactDetails['countryCode'],
                'studyingWorking' => $contactDetails['studyingWorking'],
                'country' => $contactDetails['country'],
                'budget' => $contactDetails['budget'],
                'dateFrom' => $contactDetails['dateFrom'],
                'dateTo' => $contactDetails['dateTo'],
                'acomodationType' => $contactDetails['acomodationType'],
                'message' => $contactDetails['message']
            );

            if (isset($email_vars)) {
                foreach ($email_vars as $k => $v) {
                    $body = str_replace('{{' . $k . '}}', $v, $body);
                }
            }
            $this->mail->Body = $body;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendEmailCallMe($contactDetails)
    {
        try {
            $this->mail->addAddress($_ENV['MAIL_TO_EMAIL']);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Formulario de contacto Call Me';
            $body = file_get_contents(__DIR__ . '/../Templates/callMe.html');

            $email_vars = array(
                'name' => $contactDetails['name'],
                'phone' => $contactDetails['phone'],
                'countryCode' => $contactDetails['countryCode']
            );

            if (isset($email_vars)) {
                foreach ($email_vars as $k => $v) {
                    $body = str_replace('{{' . $k . '}}', $v, $body);
                }
            }
            $this->mail->Body = $body;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
