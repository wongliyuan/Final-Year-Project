<?php

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Database configuration
include 'config.php';

$msg = "";

if (isset($_POST['continue'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);

    if (!$run_sql) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($run_sql) > 0) {
        echo "Email exists in database.<br>";
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        echo "Generated verification code: $verification_code<br>";

        $insert_verification_code = "UPDATE users SET verification_code='$verification_code' WHERE email='$email'";
        $run_query = mysqli_query($conn, $insert_verification_code);

        if (!$run_query) {
            die("Update query failed: " . mysqli_error($conn));
        }

        if ($run_query) {
            echo "Verification code updated in database.<br>";
            $_SESSION['email'] = $email;
            $mail = new PHPMailer(true);

            try {
                //Enable verbose debug output
                $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

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
                $mail->addAddress($email);

                //Set email format to HTML
                $mail->isHTML(true);

                $mail->Subject = 'Email verification';
                $mail->Body = '<p>Your verification code is: <b style="font-size: 20px;">' . $verification_code . '</b></p>';

                $mail->send();
                echo "Verification code sent to email.<br>";

                $msg = "<div class='alert alert-info'>We've sent a verification code to your email address</div>";
                header("Location: verify-code.php?email=" . $email);
                exit();
            } catch (Exception $e) {
                $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong while updating the verification code</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>The email address does not exist</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/otp.css"> <!-- Link to your CSS file -->
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Journaly
        </a>
        <div class="form-inline">
            <span class="mr-2">Already have an account?</span>
            <a href="login.php" class="btn btn-outline-primary">Sign In</a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center">Forgot Password</h3>
                <p class="text-center text-muted">Kindly enter your email address</p>
                <?php echo $msg; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Enter your email address" required>
                    </div>
                    <button type="submit" name="continue" class="btn btn-block btn-primary">Continue</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>&copy; Copyright 2024 Journaly All Rights Reserved.</p>
    </footer>

</body>
</html>
