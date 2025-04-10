<?php
@include 'config.php';

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['data']))
{
    function randomgenrator()
    {
       $randomNumber = rand();
       return $randomNumber;
    }
    $Gid = randomgenrator();
    $dates = date('Y-m-d');
    date_default_timezone_set('Asia/Kolkata');
    $today = date("Y-m-d");
    $currentTime = date('h:i:s');
    $email = $_GET['data'];
    $Funds = 850;

    $select = "SELECT * FROM userinfo WHERE email = '$email'";
    $result = mysqli_query($conn, $select);
 
     if(mysqli_num_rows($result) > 0)
     {
        $select = " SELECT * FROM booking_history WHERE useremail = '$email' ORDER BY `Gid` DESC LIMIT 1";
        $result = mysqli_query($conn, $select);
        // echo $email;

        if((mysqli_num_rows($result) == 0))
         {
            $insert = "INSERT INTO `booking_history` VALUES('$Gid','$email','$Funds','$today','$currentTime')";
            if (mysqli_query($conn, $insert))
            {
                 //Load Composer's autoloader
                require 'PHPMailer/Exception.php';
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';


                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'kamblerajat252@gmail.com';                     //SMTP username
                    $mail->Password   = 'syzuigzhxuayyieq';                                //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('kamblerajat252@gmail.com', 'Mailer');
                    $mail->addAddress("$email", '');     //Add a recipient
                


                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Gas Booking System';
                    $mail->Body    = "Gas Book Sucessfully Gas Number/Id is <b>$Gid</b>";
                    $mail->send();
                    echo "Gas Book Sucessfully Gas Number/Id is ",$Gid;
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            }
            else 
            {
               echo "Error updating record: " . mysqli_error($conn);
            }
         }  
        else if(mysqli_num_rows($result) > 0)
         {
             while($row = mysqli_fetch_assoc($result)) {
                $date_string  = $row['Dates'];
                $date_object1 = new DateTime($date_string);
                // $date_string = $date_object->format('Y-m-d');

                $date_object2 = new DateTime($today);
                // $date_string2 = $date_object->format('Y-m-d');
                
                // $dateval = $date_string2 - $date_string;
                $dateval = $date_object1->diff($date_object2);
                // echo $dateval->days; // output: 7
                 if($dateval->days > 21)
                 {
                    $insert = "INSERT INTO booking_history VALUES('$Gid','$email','$Funds','$today','$currentTime')";
                    if (mysqli_query($conn, $insert))
                    {
                            //Load Composer's autoloader
                            require 'PHPMailer/Exception.php';
                            require 'PHPMailer/PHPMailer.php';
                            require 'PHPMailer/SMTP.php';


                            //Create an instance; passing `true` enables exceptions
                            $mail = new PHPMailer(true);

                        try {
                            //Server settings
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'kamblerajat252@gmail.com';                     //SMTP username
                            $mail->Password   = 'syzuigzhxuayyieq';                                //SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                            //Recipients
                            $mail->setFrom('kamblerajat252@gmail.com', 'Mailer');
                            $mail->addAddress("$email", '');     //Add a recipient
                        


                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Gas Booking System';
                            $mail->Body    = "Gas Book Sucessfully Gas Number/Id is <b>$Gid</b>";
                            $mail->send();
                            echo "Gas Book Sucessfully Gas Number/Id is ",$Gid;
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                                
                    }
                    else 
                    {
                       echo "Error updating record: " . mysqli_error($conn);
                    }
                    
                 }
     
             }
                 //Load Composer's autoloader
                 require 'PHPMailer/Exception.php';
                 require 'PHPMailer/PHPMailer.php';
                 require 'PHPMailer/SMTP.php';


                 //Create an instance; passing `true` enables exceptions
                 $mail = new PHPMailer(true);

             try {
                 //Server settings
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'kamblerajat252@gmail.com';                     //SMTP username
                    $mail->Password   = 'syzuigzhxuayyieq';                                //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                 //Recipients
                 $mail->setFrom('kamblerajat252@gmail.com', 'Mailer');
                 $mail->addAddress("$email", '');     //Add a recipient
             

                $wait= 21-$dateval->days;
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'Gas Booking System';
                 $mail->Body    = "You Can't Book A Gas You Have To Wait for <b> $wait </b> Day's";
                 $mail->send();
                 echo "You Can't Book A Gas You Have To Wait for <b>",21 - $dateval->days,"</b> Day's";
                } catch (Exception $e) {
                 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
             }
            
         }
         
     }
    else
    {
        echo "User Invalid!!";
    }

}



?>