<?php

$msg = "";

if (isset($_POST["verify"])) {
    // connect with database
    $conn = mysqli_connect("localhost", "root", "", "login");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $verification_code = mysqli_real_escape_string($conn, $_POST["verification_code"]);

    // Verify the existence of the email and verification code in the database
    $sql_check = "SELECT * FROM users WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
    $result_check = mysqli_query($conn, $sql_check);

        // Check query execution
        if (!$result_check) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result_check) > 0) {
            // Mark email as verified
            $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = '$email' AND verification_code = '$verification_code'";
            $result  = mysqli_query($conn, $sql);

            // Check query execution
            if (!$result) {
                die("Update query failed: " . mysqli_error($conn));
            }

        if (mysqli_affected_rows($conn) == 0) {
            die("Verification code failed.");
        }

        header("Location:login.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Invalid Verification Code</div>";
    }

    //exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/otp.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="index.php">
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
                <h3 class="card-title text-center">Email Verification</h3>
                <p class="text-center text-muted">Kindly enter the code</p>
                <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" required>
                        <input type="text" class="form-control" name="verification_code" placeholder="Enter code" required>
                    </div>
                    <button type="submit" name="verify" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="text-center mt-4">
        <p>&copy; Copyright 2024 Journaly All Rights Reserved.</p>
    </footer>
</body>
</html>

