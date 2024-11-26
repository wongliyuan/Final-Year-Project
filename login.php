<?php
session_start(); // Start the session

// Database configuration
include 'config.php';

$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email exists in the database
    $query = "SELECT id, password, role FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password using password_verify
        if (password_verify($password, $hashed_password)) {
            // Password is correct, allow the user to login
            $msg = "<div class='alert alert-success'>Login successful</div>";
            
            // Store the user ID in session
            $_SESSION['user_id'] = $row['id'];

            // Redirect the user based on their role
            switch ($row['role']) {
                case 'user':
                    header("Location: ../USERS/edit-profile.php");
                    break;
                case 'admin':
                    header("Location: ../ADMIN/dashboard.php");
                    break;
                case 'editor':
                    header("Location: ../EDITORS/homepage.php");
                    break;
                default:
                    // Redirect to a default page if the role is not recognized
                    header("Location: dashboard.php");
            }
            exit();
        } else {
            // Password is incorrect
            $msg = "<div class='alert alert-danger'>Incorrect password</div>";
        }
    } else {
        // Email does not exist
        $msg = "<div class='alert alert-danger'>Looks like you are new. Register now.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
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
                <h2>SIGN IN</h2>
                <?php echo $msg; ?>
                <p>Email Address</p>
                <input type="email" name="email" class="box" required>
                <p>Password</p>
                <input type="password" name="password" class="box" required>
                <a href="forgot-password.php">Forget Password?</a>
                <button name="submit" type="submit" class="signInButton">Login</button>
                <p class="create-account">Are you new? <a href="register.php">Create an Account</a></p>
            </form>
        </div>
    </div>
</body>
</html>
