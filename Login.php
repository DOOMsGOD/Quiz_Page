<?php
$host = 'localhost';
$dbname = 'quiz';
$username = 'root';
$password = '';
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) 
{
    die("Database connection failed:");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email) && !empty($password)) {
        $sql = "SELECT user_id, pass FROM login_info WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userid, $hashed_password);
        mysqli_stmt_fetch($stmt);
        if ($hashed_password) {
            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION['userid'] = $userid;
                $_SESSION['email'] = $email;
                // Redirect to Main.html
                header("Location: Main.html");
                exit();
            } else {
                echo "Invalid password. Please try again.";
            }
        } else {
            echo "No user found with this email address.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Please fill in all fields.";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="LoginStyle.css">
    </head>
    <body>
        <div class="login-container">
            <div class="left-section">
                <h1>Login Here!</h1>
            </div>
            <div class="right-section">
                <form method="POST">
                    <input type="email" name="email" placeholder="Email id/Userid" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                    <a href="Register.php" class="register-link">Register Here?</a>
                </form>
            </div>
        </div>
    </body>
</html>
