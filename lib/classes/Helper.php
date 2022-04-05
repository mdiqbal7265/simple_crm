<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__.'/../vendor/autoload.php';
// require 'MysqliDb.php';
$db = new MysqliDb('localhost', 'root', '', 'crm');

//Create an instance; passing `true` enables exceptions
$instance_mail = new PHPMailer(true);

class Helper
{

    public $title;
    public $mail;
    public $conn;

    public function __construct()
    {
        global $instance_mail;
        global $db;
        $this->mail = $instance_mail;
        $this->conn = $db;
    }


    /**
     * @Random String and Number Generator Function
     */
    public function generateRandomString($length = 25)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Random Unique Number Generator
     */
    public function random_num($len)
    {
        $ch = "0123456789";
        $l = strlen($ch) - 1;
        $str = "";
        for ($i = 0; $i < $len; $i++) {
            $x = rand(0, $l);
            $str .= $ch[$x];
        }
        return $str;
    }

    /**
     * @Check Parcel Status
     */
    public function checkStatus($statusCode = 0)
    {
        switch ($statusCode) {
            case '1':
                return "<span class='badge badge-pill badge-info'> Collected</span>";
                break;
            case '2':
                return "<span class='badge badge-pill badge-info'> Shipped</span>";
                break;
            case '3':
                return "<span class='badge badge-pill badge-primary'> In-Transit</span>";
                break;
            case '4':
                return "<span class='badge badge-pill badge-primary'> Arrived At Destination</span>";
                break;
            case '5':
                return "<span class='badge badge-pill badge-primary'> Out for Delivery</span>";
                break;
            case '6':
                return "<span class='badge badge-pill badge-primary'> Ready to Pickup</span>";
                break;
            case '7':
                return "<span class='badge badge-pill badge-success'>Delivered</span>";
                break;
            case '8':
                return "<span class='badge badge-pill badge-success'> Picked-up</span>";
                break;
            case '9':
                return "<span class='badge badge-pill badge-danger'> Unsuccessfull Delivery Attempt</span>";
                break;

            default:
                return "<span class='badge badge-pill badge-info'> Item Accepted by Courier</span>";

                break;
        }
    }

    // Public function send mail
    public function send_mail($email, $subject, $body)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.mailtrap.io';
            $this->mail->SMTPAuth = true;
            $this->mail->Port = 2525;
            $this->mail->Username = 'ef4113ce44efb0';
            $this->mail->Password = 'a0aff7124fdd5f';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->setFrom('admin@gmail.com', 'Simple CRM');
            $this->mail->addAddress($email);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();
        } catch (PDOException $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    // User Exists Check
    public function user_exists($email){
        $this->conn->where('email', $email);
        $result = $this->conn->getOne('user');
        return $result;
    }
}
