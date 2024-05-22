<?php
include 'config.php';
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['position'])) {
    header('Location: index.php');
    exit();
}

$name = $_SESSION['name'];
$userPosition = $_SESSION['position'];

if ($userPosition != 'Professor') {
    header('Location: homeStudent.php'); // nese perdoruesi nuk e ka pozicionin si professor nuk e leojn ta hap kete faqe
    exit();
}

if ($userPosition == 'Professor') {
    $namePrefix = "Prof. ";
    $usersDir = 'users.php';
} else {
    $namePrefix = "";
    $usersDir = 'usersStudent.php';
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = strtolower($_POST['email']); // strtolower ben qe emaili ne databaze te ruhet me shkronja te vogla
    $password = md5($_POST['password']);
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $position = ucfirst($_POST['position']); // ucfirst ben qe shkronja e pare e pozicionit te jete e madhe
    $interests = empty($_POST['interests']) ? 'None' : implode(', ', $_POST['interests']);

    // validimi i emailit
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
                $birthday = "";
            } else {
                echo "<script>alert('Something went wrong, please try again!')</script>";
            }
        } else {
            echo "<script>alert('A user with this email already exists!')</script>";
        }
    } else {
        echo "<script>alert('Please put in a valid email address!')</script>";
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>EduConnect - Home</title>
    <link rel="stylesheet" href="home.css">
    <link href="images/logo.ico" rel="icon" type="image/x-icon">
</head>

<body>
    <div class="header">
        <nav>
            <img src="images/logo2.png" class="logo" href="#">
            <ul class="nav-links">
                <li><a href='#' class='active'>Home</a></li>
                <li><a href="<?php echo $usersDir ?>">Users</a></li>
                <li><a href="giveawayEntries.php">Giveaway</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><a href="download.php">Download</a></li>
            </ul>
            <div class="dropdown" onmouseover="showDropdown()" onmouseleave="hideDropdown()">
                <div class="user-info" onclick="toggleDropdown()">
                    <img class="user-pfp" src="images/icons8-user-38.png">
                    <p class="welcome"><?php echo $namePrefix . $name; ?></p>
                </div>
                <div class="dropdown-content" id="dropdown">
                    <a href="profile.php"><img src="images/icons8-settings-30.png">Profile</a>
                    <a href="logout.php"><img src="images/icons8-logout-30.png">Log Out</a>
                </div>
            </div>
        </nav>
        <div class="home-container">
            <div class="login-signup-form">
                <form action="" method="post" class="login">

                    <p class="login-text">Add New User</p>

                    <div class="input-groups-container">
                        <div class="half-group">
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
                        </div>

                        <div class="half-group">
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
                        </div>
                    </div>

                    <div class="input-group">
                        <button name="submit" class="btn">Add User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>