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
    <title>EduConnect - About</title>
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
                <li><a href="#" class='active'>About Us</a></li>
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
        <div class="about">
            <h2 class='sub-title'>About Us</h2>
            <p class="description">Welcome to EduConnect, where we redefine your academic experience, making it not just informative but inspiring!</p>
            <p class="about-info">
                <strong>EduConnect</strong> is more than just a platform; it's a dynamic ecosystem designed to empower students, educators, and institutions alike. Here's what you can expect from our feature-rich platform:
                <br> <br>
                <strong>Student Portal:</strong> Immerse yourself in a feature-packed student portal. Beyond connecting with classmates and checking grades, you can join discussion forums, access resources, and collaborate on projects. Our interactive environment fosters a sense of community, turning learning into a collaborative adventure.
                <br> <br>
                <strong>Profile Personalization:</strong> Elevate your academic journey with personalized profiles. Showcase your achievements, set academic goals, and curate a digital portfolio. Your profile becomes a reflection of your academic identity, helping you stand out in the ever-evolving landscape of education.
                <br> <br>
                <strong>Student Management:</strong> For educators, EduConnect offers a comprehensive student management system. Track attendance, manage grades, and provide timely feedback. Our platform is designed to streamline administrative tasks, allowing professors to focus on what they do best – teaching.
                <br> <br>
                <strong>Notifications and Updates:</strong> Stay in the loop with real-time notifications and updates. Whether it's a class announcement, a deadline reminder, or a new resource availability, EduConnect ensures you are always informed and ready for what's next.
                <br> <br>

                Join EduConnect and embrace a revolution in education. Navigate through a world of possibilities, connect with knowledge, and embark on a transformative educational journey like never before!
            </p>
        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>