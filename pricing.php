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
    <title>EduConnect - Pricing</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                <li><a href="#" class='active'>Pricing</a></li>
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
        <h2 class='sub-title'>Pricing</h2>
        <p class="description">Check out our different plans with affordable prices, with also dicounts!<br>We also host giveaways frequently!</p>
        <div id="pricing">
            <div class="cards">
                <div class="card">
                    <i class='fas fa-user'></i>
                    <h3>Pro</h3>
                    <p>17$ <span style="text-decoration: line-through;">22$</span></p>
                    <span>-20% Discount</span>
                    <a href='#' class='price-button'>Get Now!</a>
                </div>

                <div class="card main">
                    <i class='fas fa-user-tie'></i>
                    <h3>Max</h3>
                    <p>49$ <span style="text-decoration: line-through;">58$</span></p>
                    <span>-15% Discount</span>
                    <a href='#' class='price-button'>Get Now!</a>
                </div>

                <div class="card">
                    <i class='fas fa-solid fa-user-plus'></i>
                    <h3>Pro+</h3>
                    <p>24$ <span style="text-decoration: line-through;">35$</span></p>
                    <span>-30% Discount</span>
                    <a href='#' class='price-button'>Get Now!</a>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>