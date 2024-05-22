<?php
include 'config.php';
error_reporting(0);
session_start();

if (isset($_SESSION['name'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = strtolower($_POST['email']); // strtolower ben qe emaili ne databaze te ruhet me shkronja te vogla
    $password = md5($_POST['password']);
    $rpassword = md5($_POST['rpassword']);
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $position = ucfirst($_POST['position']); // ucfirst ben qe shkronja e pare e pozicionit te jete e madhe
    $interests = empty($_POST['interests']) ? 'None' : implode(', ', $_POST['interests']);

    // validimi i emailit
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($password == $rpassword) {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if (!$result->num_rows > 0) {
                $sql = "INSERT INTO users (name, email, password, gender, birthday, position, interests) 
                VALUES ('$name', '$email', '$password', '$gender', '$birthday', '$position', '$interests')";

                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>alert('Congrats, you signed up successfully!')</script>";
                    $name = "";
                    $email = "";
                    $_POST['password'] = "";
                    $_POST['rpassword'] = "";
                    $birthday = "";
                } else {
                    echo "<script>alert('Something went wrong, please try again!')</script>";
                }
            } else {
                echo "<script>alert('A user with this email already exists!')</script>";
            }
        } else {
            echo "<script>alert('The passwords you put in don\'t match!')</script>";
        }
    } else {
        echo "<script>alert('Please put in a valid email address!')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>EduConnect - Sign up</title>
    <link rel="stylesheet" href="style.css">
    <link href="images/logo.ico" rel="icon" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-signup-form">
            <form action="" method="post" class="login">

                <p class="login-text">EduConnect - Sign up</p>

                <div class='input-group'>
                    <p>Full Name:</p>
                    <input type="text" placeholder="Full Name" name="name" required>
                </div>

                <div class='input-group'>
                    <p>Email:</p>
                    <input type="email" placeholder="Email" name="email" required>
                </div>

                <div class='input-group'>
                    <p>Password:</p>
                    <input type="password" placeholder="Password" name="password" required>
                </div>

                <div class='input-group'>
                    <p>Repeat Password:</p>
                    <input type="password" placeholder="Repeat Password" name="rpassword" required>
                </div>

                <div id="gender" class="input-group">
                    <p>Gender:</p> <br>
                    <input type="radio" id="male" name="gender" value="Male" checked>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                </div>

                <div id="birthday" class="input-group">
                    <p>Birthday:</p>
                    <input id="date" type="date" name="birthday" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" required> <!-- max eshte gjithmode data ma e re -->
                </div>

                <div id="position" class="input-group">
                    <p for="position">Position:</p> <br>
                    <select id="positionSelect" name="position" required>
                        <option value="student">Student</option>
                        <option value="professor">Professor</option>
                    </select>
                </div>

                <div id="interests" class="input-group">
                    <p>Interests:</p> <br>
                    <input type="checkbox" id="math" name="interests[]" value="Math">
                    <label for="math">Math</label>
                    <input type="checkbox" id="sports" name="interests[]" value="Sports">
                    <label for="sports">Sports</label>
                    <input type="checkbox" id="science" name="interests[]" value="Science">
                    <label for="science">Science</label>
                </div>


                <div class="input-group">
                    <button name="submit" class="btn">Sign up</button>
                </div>

                <p class="login-signup-text">Already have an account? <a href="index.php">Login now!</a></p>

            </form>
        </div>
    </div>
</body>

</html>