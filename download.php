<?php
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['position'])) {
    header('Location: index.php');
    exit();
}

$name = $_SESSION['name'];
$userPosition = $_SESSION['position'];

if ($userPosition == 'Professor') {
    $namePrefix = "Prof. ";
    $usersDir = 'users.php';
    $homeDir = 'home.php';
    $giveawayDir = '<li><a href="giveawayEntries.php">Giveaway</a></li>';
} else {
    $namePrefix = "";
    $usersDir = 'usersStudent.php';
    $homeDir = 'homeStudent.php';
    $giveawayDir = '';
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>EduConnect - Download</title>
    <link rel="stylesheet" href="home.css">
    <link href="images/logo.ico" rel="icon" type="image/x-icon">
</head>

<body>
    <div class="header">
        <nav>
            <img src="images/logo2.png" class="logo" href="#">
            <ul class="nav-links">
                <li><a href='<?php echo $homeDir ?>'>Home</a></li>
                <li><a href="<?php echo $usersDir ?>">Users</a></li>
                <?php echo $giveawayDir ?>
                <li><a href="about.php">About Us</a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><a href="#" class='active'>Download</a></li>
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

        <h2 class='sub-title'>Download</h2>
        <p class="description">Check out our desktop app, avalible for Windows, Mac and Linux.<br> iOS and Android comming soon!</p>
        <div class="download-section">
            <div class="video">
                <h3>Video showcasing the application!</h3>
                <video controls>
                    <source src="images/Arion Ukshini.mp4" type="video/mp4">
                </video>
            </div>
            <div class="download-link">
                <h3>Download for your specific device!</h3>
                <p style="margin-top: 15px;">Presently, our application is accessible on Windows, Mac, and Linux, but we're not stopping there! Our dynamic team is diligently crafting mobile apps to broaden accessibility, and you can look forward to finding them right here upon their release. Rest assured, our app is designed with a plethora of features to cater to your diverse needs, providing a seamless and enriching user experience. Stay tuned for the latest developments!</p>
                <a href="images/Arion Ukshini.zip">Download</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>