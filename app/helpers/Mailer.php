<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../app/lib/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../app/lib/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once '../app/lib/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';

class Mailer
{
    private $mail;
    private $base_url;

    public function __construct()
    {
        $this->base_url = $GLOBALS['base_url'];
        $this->mail = new PHPMailer(true);

        try {
            // Server settings
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'mailer.sugam@gmail.com'; // Your Gmail address
            $this->mail->Password = 'rufy maav dlxp vrpu'; // Your Gmail password or app password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;

            // Sender info
            $this->mail->setFrom('mailer.sugam@gmail.com', 'Medilog');
        } catch (Exception $e) {
            echo "Mailer Error: " . $e->getMessage();
        }
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            // Recipient
            $this->mail->addAddress($to);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            // Send mail
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }

    public function accountCreationMail($data)
    {
        $subject = 'Account Created';
        $body = "
        <p>Hello " . $data['name'] . ",</p>
        <p>We are excited to inform you that your account has been successfully created. Below are your login credentials:</p>
        <p><strong>Username:</strong> " . $data['username'] . "</p>
        <p><strong>Password:</strong> " . $data['password'] . "</p>
        <p>For your security, we highly recommend that you change your password immediately after logging in for the first time.</p>
        <p>You can log in using the following link: <a href='. $this->base_url .'>" . $this->base_url . "</a></p>
        <p>For any query, please contact our support team.</p>
        <p>Thank you</p>
        ";
        return $this->sendMail($data['email'], $subject, $body);
    }

    // public function passwordResetMail($data)
    // {
    //     $subject = 'Password Reset';
    //     $body = "
    //     <p>Hello " . $data['name'] . ",</p>
    //     <p>We have received a request to reset your password. Below are your new login credentials:</p>
    //     <p><strong>Username:</strong> " . $data['username'] . "</p>
    //     <p><strong>Password:</strong> " . $data['password'] . "</p>
    //     <p>For your security, we highly recommend that you change your password immediately after logging in.</p>
    //     <p>You can log in using the following link: <a href='" . $this->base_url . "auth/login'>" . $this->base_url . "auth/login</a></p>
    //     <p>Thank you</p>
    //     ";
    //     return $this->sendMail($data['email'], $subject, $body);
    // }
}