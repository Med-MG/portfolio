<?php 

namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Sendemail
{


        /**
     * Find a personal information 
     *
     * @return mixed User object if found, false otherwise
     */
    public static function send($data)
    {
        

        $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = Config::MAILER_EMAIL;   //username
                    $mail->Password = Config::MAILER_PASS;   //password
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;                    //smtp port
                  
                    $fullname = htmlspecialchars(stripslashes(trim($_POST['name']))); // Get Name value from HTML Form
                    $email = htmlspecialchars(stripslashes(trim($_POST['email']))); // Get Email Value
                    $msg = htmlspecialchars(stripslashes(trim($_POST['message']))); // Get Message Value
                    if(!preg_match("/^[A-Za-z .'-]+$/", $fullname)){
                    $name_error = 'Invalid full name';
                    }
                    if(!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/", $email)){
                    $email_error = 'Invalid email';
                    }
                    if(strlen($msg) === 0){
                    $message_error = 'Your message should not be empty';
                    }
                    $to = Config::RECIVER_EMAIL; // You can change  your Email in config
                    $subject = "contect from portfolio"; // This is your subject
                     
                    // HTML Message Starts here
                    $message ="
                    <html>
                        <body>
                            <table style='width:600px;'>
                                <tbody>
                                    <tr>
                                        <td style='width:150px'><strong>Name: </strong></td>
                                        <td style='width:400px'>$fullname</td>
                                    </tr>
                                    <tr>
                                        <td style='width:150px'><strong>Email ID: </strong></td>
                                        <td style='width:400px'>$email</td>
                                    </tr>
                                    <tr>
                                        <td style='width:150px'><strong>Message: </strong></td>
                                        <td style='width:400px'>$msg</td>
                                    </tr>
                                </tbody>
                            </table>
                        </body>
                    </html>
                    ";
                    // HTML Message Ends here
        
                    $mail->setFrom($email, $fullname);
                    $mail->addAddress($to, 'Med Mouiguina');
                 
                 
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                 
                    
                    
                    if($mail->send() && !isset($name_error) && !isset($email_error) && !isset($message_error)){
                    // Message if mail has been sent
                     return true;
                    }else{
                        // Message if mail has been not sent
                        return false;       
                    }
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                }
        
               
        
        
        
    }
}


?>