<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['message'])){

    $mail = new PHPMailer(true);

    //Enable SMTP debugging.
    $mail->SMTPDebug = 3;                               
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();            
    //Set SMTP host name                          
    $mail->Host = "wb-productions.id";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                          
    //Provide username and password     
    $mail->Username = "cs@wb-productions.id";                 
    $mail->Password = "Wbproductions2020";                           
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";                           
    //Set TCP port to connect to
    $mail->Port = 587;                                   

    $mail->From = "cs@wb-productions.id";
    $mail->FromName = "CS WB productions";

    $mail->addAddress("admin@wb-productions.id", "Not Found");

    $mail->isHTML(true);

    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    if(isset($_POST['subject'])){
        $subject = $_POST['subject'];
        $mail->Subject = $subject;
    }

    $browser = get_browser(null, true);
    
    $ip = get_client_ip();
    $platform = $browser['platform'];
    $browser = $browser['browser'];
    $version = '2';

    $mail->Body = "<table>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>$name</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>$email</td>
                    </tr>
                    <tr>
                        <td>message</td>
                        <td>:</td>
                        <td>$message</td>
                    </tr>
                    <tr>
                        <td>Device</td>
                        <td>:</td>
                        <td>
                            <table>
                                <tr>
                                    <td>IP</td>
                                    <td>:</td>
                                    <td>$ip</td>
                                </tr>
                                <tr>
                                    <td>Platform</td>
                                    <td>:</td>
                                    <td>$platform</td>
                                </tr>
                                <tr>
                                    <td>Browser</td>
                                    <td>:</td>
                                    <td>$browser</td>
                                </tr>
                                <tr>
                                    <td>Version</td>
                                    <td>:</td>
                                    <td>$version</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                   </table>";
    $mail->AltBody = "This is the plain text version of the email content";

    try {
        $mail->send();
        echo "<center>Successfully</center>";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

 