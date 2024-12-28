<?php
    $host = 'localhost';
    $dbname = 'quiz'; 
    $username = 'root';
    $password = ''; 
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_POST["Userid"];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (!empty($email) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO login_info (user_id, email, pass) VALUES (?, ?, ?)";
            $query   = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($query, "iss", $userid, $email, $hashed_password);
            if (mysqli_stmt_execute($query)) {                                                                                                                   
                header("Location: Login.php");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($query);
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
        <title>Registration Page</title>
        <link rel="stylesheet" href="RegisterStyle.css">
    </head>
    <body>
        <div class="container">
            <div class="left-section">
                <form action="register.php" method="POST" onsubmit="return validateForm()">
                    <h2>Register Here!</h2>
                    <input type="Text" name="Userid" id="Userid" placeholder="Userid" required>
                    <input type="email" name="email" id="email" placeholder="Email ID" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="submit">Register</button>
                    <p class="link">Already have an account? <a href="Login.php">Login</a></p>
                </form>
            </div>
            <div class="right-section">
                <h1>Register<br>Here!</h1>
            </div>
        </div>
        <script src="RegisterJs.js"></script>
    </body>
</html>
