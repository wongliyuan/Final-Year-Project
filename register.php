<!-- <?php

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Database configuration
include 'config.php';

$msg = "";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $role = mysqli_real_escape_string($conn, "user");
    $verification_code = mysqli_real_escape_string($conn, substr(number_format(time() * rand(), 0, '', ''), 0, 6));

    if ($password === $confirm_password) {
        // Hash the password using password_hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, email, password, role, verification_code) VALUES ('{$username}', '{$email}', '{$hashed_password}', '{$role}', '{$verification_code}')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // echo "<div style='display:none;'></div>";
            $mail = new PHPMailer(true);

            try {
                    //Enable verbose debug output
                    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
        
                    //Send using SMTP
                    $mail->isSMTP();
        
                    //Set the SMTP server to send through
                    $mail->Host = 'smtp.gmail.com';
        
                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;
        
                    //SMTP username
                    $mail->Username = 'liyuan.wong@socar.my';
        
                    //SMTP password
                    $mail->Password = 'qbhcrlbufkvvxncv';
        
                    //Enable TLS encryption;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->Port = 587;
        
                    //Recipients
                    $mail->setFrom('liyuan.wong@socar.my', 'JOURNALY');
        
                    //Add a recipient
                    $mail->addAddress($email, $username);
        
                    //Set email format to HTML
                    $mail->isHTML(true);
        
                    $mail->Subject = 'Email verification';
                    $mail->Body    = '<p>Your verification code is: <b style="font-size: 20px;">' . $verification_code . '</b></p>';
        
                    $mail->send();
        
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        
                    header("Location: email-verification.php?email=" . $email);
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
                $msg = "<div class='alert alert-info'>We've sent a verification code to your email address</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
?> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>
    <div class="container">
        <div class="left side">
            <h1>JOURNALY</h1>
            <img src="images/book.png">
            <p>Unlock the World of Scholarly Collaboration!</p>
        </div>
        <div class="right side">
            <form action="" method="post" class="form">
                <?php echo $msg; ?>
                <h2>SIGN UP</h2>
                <!-- <div>
                    <button type="google" class="googleSignIn">
                        <img src="images/google.png">Sign Up with Google
                    </button>
                </div> -->
                <p>Username</p>
                <input type="text" name="username" class="box" value="<?php if (isset($_POST['submit'])) { echo $username; } ?>" required>
                <p>Email Address</p>
                <input type="email" name="email" class="box" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                <p>Password</p>
                <input type="password" name="password" class="box" required>
                <p>Confirm Password</p>
                <input type="password" name="confirm_password" class="box" required>
                <button name="submit" type="submit" class="signUpButton">Sign Up</button>
                <p class="login">Already have an account? <a href="login.php">Sign In</a></p>
            </form>
        </div>
    </div>
</body>
</html>
