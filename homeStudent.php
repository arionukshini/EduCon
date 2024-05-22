<?php
include 'config.php';
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['position']) || !isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$name = $_SESSION['name'];
$userPosition = $_SESSION['position'];
$userEmail = $_SESSION['email'];

$result = mysqli_query($conn, "SELECT id FROM users WHERE name='$name' AND email='$userEmail' AND position='$userPosition'");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $userId = $row['id'];
} else {
    echo "<script>alert('User ID not found!')</script>";
    exit();
}

if ($userPosition != 'Student') {
    header('Location: home.php'); // nese perdoruesi nuk e ka pozicionin si student nuk e leojn ta hap kete faqe per shkak se kjo faqe vlen vetem per studentet
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
    $age = $_POST['age'];
    $number = $_POST['phone'];
    $school = $_POST['school'];
    $subject = $_POST['subject'];
    $reason = $_POST['reason'];
    $employed = $_POST['employed'];

    $sql = "SELECT * FROM giveaway WHERE userid='$userId'";
    $result = mysqli_query($conn, $sql);
    if (!$result->num_rows > 0) {
        $sql = "INSERT INTO giveaway (userid, username, age, phone, school, subject, employed, reason) 
                VALUES ('$userId', '$name', '$age', '$number', '$school', '$subject', '$employed', '$reason')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('You successfully applied for the giveaway. We\'ll notify you through email or phone number if you won!')</script>";
            $age = '';
            $number = '';
            $school = '';
            $subject = '';
            $reason = '';
        } else {
            echo "<script>alert('Something went wrong, please try again2!')</script>";
        }
    } else {
        echo "<script>alert('You already entered the giveaway!')</script>";
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
            <div class="giveaway-form">
                <form action="" method="post" class="giveaway">

                    <p class="giveaway-text">Apply For Giveaway</p>

                    <div class='input-group'>
                        <p>What is your age?</p>
                        <input type="number" placeholder="Age" name="age" required>
                    </div>

                    <div class='input-group'>
                        <p>What is your phone number?</p>
                        <input type="tel" placeholder="Phone Number" name="phone" pattern="[0-9]{9}" required>
                    </div>

                    <div class='input-group'>
                        <p>Which school did/do you study at?</p>
                        <input type="text" placeholder="School Name" name="school" required>
                    </div>

                    <div id='subject' class="input-group">
                        <p>What is your favourite subject?</p>
                        <select id="subjectSelect" name="subject" required>
                            <option value="Albanian">Albanian</option>
                            <option value="English">English</option>
                            <option value="Math">Math</option>
                            <option value="IT">IT</option>
                            <option value="Physics">Physics</option>
                            <option value="Biology">Biology</option>
                            <option value="Chemistry">Chemistry</option>
                        </select>
                    </div>

                    <div id="employed" class="input-group">
                        <p>Are you employed?</p> <br>
                        <input type="radio" id="yes" name="employed" value="Yes" checked>
                        <label for="yes">Yes</label>
                        <input type="radio" id="no" name="employed" value="No">
                        <label for="no">No</label>
                    </div>

                    <div class="input-group">
                        <p>Why should we choose you:</p>
                        <textarea id="reason" name="reason" rows="3" cols="130" placeholder="Write why should we choose you in particular!" required></textarea>
                    </div>

                    <div class="input-group">
                        <button name="submit" class="btn">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>