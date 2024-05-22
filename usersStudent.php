<?php
include 'config.php';
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['position'])) {
    header('Location: index.php');
    exit();
}

$name = $_SESSION['name'];

if ($_SESSION['position'] == 'Professor') {
    $namePrefix = "Prof. ";
} else {
    $namePrefix = "";
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>EduConnect - Users</title>
    <link rel="stylesheet" href="home.css">
    <link href="images/logo.ico" rel="icon" type="image/x-icon">
</head>

<body>
    <div class="header">
        <nav>
            <img src="images/logo2.png" class="logo" href="#">
            <ul class="nav-links">
                <li><a href='home.php'>Home</a></li>
                <li><a href="#" class='active'>Users</a></li>
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
                <div class="table-container2">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Birthday</th>
                            <th>Position</th>
                            <th>Interests</th>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["gender"] . "</td>
                <td>" . $row["birthday"] . "</td>
                <td>" . $row["position"] . "</td>
                <td>" . $row["interests"] . "</td>
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