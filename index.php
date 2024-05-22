<?php

include 'config.php';
error_reporting(0);
session_start();

if (isset($_SESSION['name'])) {
    if ($_SESSION['position'] == 'Professor') {
        header("Location: home.php");
    } else {
        header("Location: homeStudent.php");
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['name'] = $row['name'];
        $_SESSION['position'] = $row['position'];
        $_SESSION['email'] = $row['email'];

        if ($_SESSION['position'] == 'Professor') {
            header("Location: home.php");
        } else {
            header("Location: homeStudent.php");
        }
    } else {
        echo "<script>alert('The email or password you put in is wrong!')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>EduConnect - Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="images/logo.ico" rel="icon" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-signup-form">
            <form action="" method="post" class="login">

                <p class="login-text">EduConnect - Login</p>

                <div class='input-group'>
                    <p>Email:</p>
                    <input type="email" placeholder="Email" name="email" required>
                </div>

                <div class='input-group'>
                    <p>Password:</p>
                    <input type="password" placeholder="Password" name="password" required>
                </div>

                <div class="input-group">
                    <button name="submit" class="btn" style="margin-top: 30px;">Login</button>
                </div>

                <p class="login-signup-text">Don't have an account? <a href="signup.php">Sign up now!</a></p>

            </form>
        </div>
    </div>
</body>

</html>