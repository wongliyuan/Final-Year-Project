<?php
// Database configuration
include 'config.php';

$msg = "";

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password === $confirm_password) {
        // Hash the new password using password_hash
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update the password in the database
        $update_password = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_password);

        if ($run_query) {
            $msg = "<div class='alert alert-info'>Password reset successfully</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Passwords do not match</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/otp.css">
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
                <h3 class="card-title text-center">Reset Password</h3>
                <?php echo $msg; ?>
                <form action="" method="POST">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" required />
                    <div class="form-group">
                        <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" name="reset" class="btn btn-block btn-primary">Reset</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>&copy; Copyright 2024 Journaly All Rights Reserved.</p>
    </footer>

</body>
</html>
