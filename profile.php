<?php
include 'config.php';
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['position']) || !isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$userName = $_SESSION['name'];
$userPosition = $_SESSION['position'];
$userEmail = $_SESSION['email'];

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

$result = mysqli_query($conn, "SELECT id FROM users WHERE name='$userName' AND email='$userEmail' AND position='$userPosition'");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $userId = $row['id'];
} else {
    echo "<script>alert('User ID not found!')</script>";
    exit();
}

// marrja e te dhenave te perdoruesit
$query = "SELECT * FROM users WHERE id='$userId'";
$result = mysqli_query($conn, $query);

while ($row = $result->fetch_assoc()) {
    $userPassword = $row['password'];
    $userGender = $row['gender'];
    $userDate = $row['birthday'];
    $userInterests = $row['interests'];
}

// kthimi i passwordit te ekriptum ne password normal, duke perdor nje faqe dhe marrjen e passwordit prej kodit the htmls
// ku merr passwordin e enkriptuar dhe e dekripton, kam provu me perdor nje api por nuk funksionte prandaj jame duke perdor kete metode 
$url = "https://md5.gromweb.com/?md5=" . $userPassword;

// perdorimi i nje user agjenti qe me ba simulate/mimike nje browser/shfletues
$options = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
    ],
];

$context = stream_context_create($options);

// marrja e kontentit te html prej faqes
$html = @file_get_contents($url, false, $context);

if ($html !== false) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument;
    $doc->loadHTML($html);
    libxml_clear_errors();

    // e kerkon elementin ne html me <a>, pra link
    // pastaj me vone e kerkon linkun qe ka classes "String", spese aty ruhet passwordi tek faqja dhe kete vlere e ruan tek $reversdString
    $strings = $doc->getElementsByTagName('a');

    $found = false;
    foreach ($strings as $string) {
        if ($string->getAttribute('class') == 'String') {
            $reversedString = $string->nodeValue;
            $found = true;
            break;
        }
    }

    if ($found) {
        // e ruan passwordin ne nje text file (per testim)
        // dhe ne variablen $userPassword qe me paraqit me poshte tek pjesa e te dhenave te perdoruesit
        $file_path = "output.txt";
        file_put_contents($file_path, "Original String: " . $reversedString);
        $userPassword = $reversedString;
        echo "<script>console.log('Original String has been saved to $file_path')</script>";
    } else {
        echo "<script>console.log('Error: String not found on the website.')</script>";
    }
} else {
    echo "<script>console.log('Error: Unable to fetch content from the website. Check if the URL is accessible and try again.')</script>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["editAcc"])) {
        $updatedName = $_POST['name'];
        $updatedEmail = strtolower($_POST['email']);
        $updatedPassword = md5($_POST['password']);
        $updatedGender = $_POST['gender'];
        $updatedBirthday = $_POST['birthday'];
        $updatedInterests = empty($_POST['interests']) ? 'None' : implode(', ', $_POST['interests']);

        $emptyCheck = empty($updatedName) || empty($updatedEmail) || empty($updatedPassword) || empty($updatedGender) || empty($updatedBirthday);
        $genderCheck = $updatedGender == 'Male' || $updatedGender == 'Female';

        if (!$emptyCheck) {

            // validimi i emailit
            if (filter_var($updatedEmail, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM users WHERE email='$updatedEmail'";
                $queryResult = mysqli_query($conn, $sql);

                $emailRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM users WHERE id='$userId'"));
                $oldEmail = $emailRow['email'];

                $result = $queryResult && ($oldEmail == $updatedEmail);

                if ($result) {
                    if ($genderCheck) {

                        $updateQuery = "UPDATE users SET name = '$updatedName', email = '$updatedEmail', password = '$updatedPassword', gender = '$updatedGender', birthday = '$updatedBirthday', interests = '$updatedInterests' WHERE id = $userId";
                        $updateGiveaway = "UPDATE giveaway SET username = '$updatedName' WHERE userid = $userId";
                        mysqli_query($conn, $updateGiveaway);

                        if (mysqli_query($conn, $updateQuery) === TRUE) {
                            $_SESSION['name'] = $updatedName;
                            $_SESSION['email'] = $updatedEmail;
                            echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
                            exit();
                        } else {
                            echo "<script>alert('Error updating user: " . $conn->error . "')</script>";
                        }
                    } else {
                        echo "<script>alert('The gender you put in is not correct, please put in Male or Female!')</script>";
                    }
                } else {
                    echo "<script>alert('This email is alreay in use!')</script>";
                }
            } else {
                echo "<script>alert('Please enter a valid email, that contains @ and .')</script>";
            }
        } else {
            echo "<script>alert('Please make sure you fill in all of the information!')</script>";
        }
    } elseif (isset($_POST["deleteAcc"])) {
        echo "
            <script>
                var userConfirmation = window.prompt('Are you sure you want to delete your account? Type YES to confirm.');

                if (userConfirmation && userConfirmation.toUpperCase() === 'YES') {
                    var deleteQuery = 'DELETE FROM users WHERE id=$userId';
                    // Execute the deletion query
                    " . mysqli_query($conn, "DELETE FROM users WHERE id=$userId") . ";
                    " . mysqli_query($conn, "DELETE FROM giveaway WHERE userid=$userId") . ";
                    alert('Your account has been deleted!');
                    window.location.href='logout.php';
                } else {
                    alert('Deletion canceled.');
                    window.location.href='profile.php';
                }
            </script>
        ";
    }
}


?>

<!DOCTYPE HTML>
<html>

<head>
    <title>EduConnect - Profile</title>
    <link rel="stylesheet" href="profile.css">
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
                <li><a href="download.php">Download</a></li>
            </ul>
            <div class="dropdown" onmouseover="showDropdown()" onmouseleave="hideDropdown()">
                <div class="user-info" onclick="toggleDropdown()">
                    <img class="user-pfp" src="images/icons8-user-38.png">
                    <p class="welcome"><?php echo $namePrefix . $userName; ?></p>
                </div>
                <div class="dropdown-content" id="dropdown">
                    <a href="profile.php"><img src="images/icons8-settings-30.png">Profile</a>
                    <a href="logout.php"><img src="images/icons8-logout-30.png">Log Out</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="top-container">
                <img src="images/icons8-user-100.png" class="profile-img">
                <h2><?php echo $userName ?></h2>
            </div>
            <form action="" method="post" class="info" id="profile-form">
                <div class="half-group">
                    <label for="id">ID:</label>
                    <textarea rows="1" cols='auto' name="id" disabled><?php echo $userId ?></textarea>

                    <label for="name">Name:</label>
                    <textarea rows="1" cols='auto' name="name" id="name" for='profile'></textarea>

                    <label for="email">Email:</label>
                    <textarea rows="1" cols='auto' name="email" id="email"></textarea>

                    <label for="password">Password:</label>
                    <textarea rows="1" cols='auto' name="password" id="password"></textarea>
                </div>
                <div class="half-group">
                    <label for="gender">Gender:</label>
                    <textarea rows="1" cols='auto' name="gender" id="gender"></textarea>

                    <label for="brithday">Birthday:</label>
                    <input type="date" name="birthday" id="birthday" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>"></input>

                    <label for="position">Position:</label>
                    <textarea rows="1" cols='auto' name="position" disabled><?php echo $userPosition ?></textarea>

                    <label for="interests">Interests:</label>
                    <div name="interests" class="interests">
                        <div>
                            <input type="checkbox" id="math" name="interests[]" value="Math" <?php if (in_array('Math', explode(', ', $userInterests))) echo 'checked'; ?>>
                            <label for="math">Math</label>
                        </div>
                        <div>
                            <input type="checkbox" id="sports" name="interests[]" value="Sports" <?php if (in_array('Sports', explode(', ', $userInterests))) echo 'checked'; ?>>
                            <label for="sports">Sports</label>
                        </div>
                        <div>
                            <input type="checkbox" id="science" name="interests[]" value="Science" <?php if (in_array('Science', explode(', ', $userInterests))) echo 'checked'; ?>>
                            <label for="science">Science</label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="buttons">
                <button name="editAcc" form="profile-form" class="btn" for='profile'>Save Edits</button>
                <button name="deleteAcc" form="profile-form" class="btn" for='profile'>Delete Account</button>
            </div>
        </div>

        <?php
        $conn->close();
        ?>
    </div>
    <script>
        var nameElement = document.getElementById('name');
        var emailElement = document.getElementById('email');
        var passwordElement = document.getElementById('password');
        var genderElement = document.getElementById('gender');
        var birthdayElement = document.getElementById('birthday');

        nameElement.value = '<?php echo addslashes($userName); ?>';
        emailElement.value = '<?php echo addslashes($userEmail); ?>';
        passwordElement.value = '<?php echo addslashes($userPassword); ?>';
        genderElement.value = '<?php echo addslashes($userGender); ?>';
        birthdayElement.value = '<?php echo addslashes($userDate); ?>';
    </script>
    <script src="script.js"></script>

</body>

</html>