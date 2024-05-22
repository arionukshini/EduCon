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
    $homeDir = 'home.php';
} else {
    $namePrefix = "";
    $usersDir = 'usersStudent.php';
    $homeDir = 'homeStudent.php';
}

$sql = "SELECT * FROM giveaway";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>EduConnect - Giveaway Entries</title>
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
                <li><a href="#" class='active'>Giveaway</a></li>
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
        <div class="container">
            <div class="users">
                <h2 class="users-title">User List</h2>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Submit ID</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Age</th>
                            <th>Phone Number</th>
                            <th>School</th>
                            <th>Subject</th>
                            <th>Employed</th>
                            <th>Reason</th>
                            <th>Submition Time</th>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            // nese arsyeja eshte me e gjate se 150 karaktere atehere ajo shkurtohet dhe shfaqet ... tek ajo
                            $reason = strlen($row["reason"]) > 150 ? substr($row["reason"], 0, 150) . "..." : $row["reason"];

                            echo "<tr>
                            <td>" . $row["submitid"] . "</td>
                            <td>" . $row["userid"] . "</td>
                            <td>" . $row["username"] . "</td>
                            <td>" . $row["age"] . "</td>
                            <td>" . $row["phone"] . "</td>
                            <td>" . $row["school"] . "</td>
                            <td>" . $row["subject"] . "</td>
                            <td>" . $row["employed"] . "</td>
                            <td>" . $reason . "</td>
                            <td>" . $row["timestamp"] . "</td>
                            </tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <?php
        $conn->close();
        ?>
    </div>
    <script src="script.js"></script>
</body>

</html>