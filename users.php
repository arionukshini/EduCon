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
    header('Location: usersStudent.php'); // nese perdoruesi nuk e ka pozicionin si professor nuk e leojn ta hap kete faqe
    exit();
}

if ($userPosition == 'Professor') {
    $namePrefix = "Prof. ";
    $homeDir = 'home.php';
} else {
    $namePrefix = "";
    $homeDir = 'homeStudent.php';
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// vlerat default
$id = '';
$name2 = '';
$email = '';
$password = '';
$gender = '';
$birthday = '';
$position = '';
$oppositePosition = '';
$interests = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    if (isset($_POST['getUser'])) {
        $query = "SELECT * FROM users WHERE id = $id";
        $userResult = mysqli_query($conn, $query);

        if ($userResult->num_rows > 0) {
            $userDetails = $userResult->fetch_assoc();

            $id = $userDetails['id'];
            $name2 = $userDetails['name'];
            $email = $userDetails['email'];
            $gender = $userDetails['gender'];
            $birthday = $userDetails['birthday'];
            $position = $userDetails['position'];
            $interests = $userDetails['interests'];
        } else {
            echo "<script>alert('User with ID $id does not exist.')</script>";
        }
    } else if (isset($_POST['editUser'])) {
        $query = "SELECT * FROM users WHERE id = $id";
        $userResult = mysqli_query($conn, $query);

        if ($userResult->num_rows > 0) {
            $newName = $_POST['name'];
            $newEmail = strtolower($_POST['email']);
            $newPassword = md5($_POST['password']);
            $newGender = ucfirst($_POST['gender']);
            $newBirthday = $_POST['birthday'];
            $newPosition = $_POST['position'];
            $newInterests = empty($_POST['interests']) ? 'None' : implode(', ', $_POST['interests']);

            $emptyCheck = empty($id) || empty($newName) || empty($newEmail) || empty($newPassword) || empty($newGender) || empty($newBirthday);
            $genderCheck = $newGender == 'Male' || $newGender == 'Female';

            // kushtezimi se a jane fushat e plotesura
            if (!$emptyCheck) {

                // validimi i emailit
                if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $sql = "SELECT * FROM users WHERE email='$newEmail'";
                    $queryResult = mysqli_query($conn, $sql);

                    $emailRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM users WHERE id='$id'"));
                    $oldEmail = $emailRow['email'];

                    $result = $queryResult && ($oldEmail == $newEmail);

                    if ($result) {
                        // kushtezimi se a eshte gjinia e zgjedhur si duhet
                        if ($genderCheck) {

                            $updateQuery = "UPDATE users SET name = '$newName', email = '$newEmail', password = '$newPassword', gender = '$newGender', birthday = '$newBirthday', position = '$newPosition', interests = '$newInterests' WHERE id = $id";
                            $updateGiveaway = "UPDATE giveaway SET username = '$newName' WHERE userid = $id";
                            mysqli_query($conn, $updateGiveaway);

                            if (mysqli_query($conn, $updateQuery) === TRUE) {
                                echo "<script>alert('User with ID $id updated successfully.'); window.location.href='users.php';</script>";
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
        } else {
            echo "<script>alert('User with ID $id does not exist.')</script>";
        }
    } else if (isset($_POST['deleteUser'])) {
        $deleteID = $_POST['id'];

        $query = "SELECT * FROM users WHERE id=$deleteID";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            echo "
            <script>
                var userConfirmation = window.prompt('Are you sure you want to delete the user with ID $deleteID? Type YES to confirm.');

                if (userConfirmation && userConfirmation.toUpperCase() === 'YES') {
                    var deleteQuery = 'DELETE FROM users WHERE id=$deleteID';
                    // Execute the deletion query
                    " . mysqli_query($conn, "DELETE FROM users WHERE id=$deleteID") . ";
                    " . mysqli_query($conn, "DELETE FROM giveaway WHERE userid=$deleteID") . ";
                    alert('User with ID $deleteID deleted.');
                    window.location.href='users.php';
                } else {
                    alert('Deletion canceled.');
                    window.location.href='users.php';
                }
            </script>
        ";
        } else {
            echo "<script>alert('User with ID $deleteID does not exist.'); window.location.href='users.php';</script>";
        }
    } else if (isset($_POST['addUser'])) {
        $addName = $_POST['name'];
        $addEmail = strtolower($_POST['email']);
        $addPassword = md5($_POST['password']);
        $addGender = ucfirst($_POST['gender']);
        $addBirthday = $_POST['birthday'];
        $addPosition = $_POST['position'];
        $addInterests = empty($_POST['interests']) ? 'None' : implode(', ', $_POST['interests']);

        $emptyCheck = empty($addName) || empty($addEmail) || empty($addPassword) || empty($addGender) || empty($addBirthday);
        $genderCheck = $addGender == 'Male' || $addGender == 'Female';

        // kushtezimi se a jane fushat e plotesura
        if (!$emptyCheck) {

            // validimi i emailit
            if (filter_var($addEmail, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM users WHERE email='$addEmail'";
                $result = mysqli_query($conn, $sql);

                if (!$result->num_rows > 0) {
                    // kushtezimi se a eshte gjinia e zgjedhur si duhet
                    if ($genderCheck) {

                        $addQuery = "INSERT INTO users (name, email, password, gender, birthday, position, interests) 
                        VALUES ('$addName', '$addEmail', '$addPassword', '$addGender', '$addBirthday', '$addPosition', '$addInterests')";

                        if (mysqli_query($conn, $addQuery) === TRUE) {
                            echo "<script>alert('User added successfully.'); window.location.href='users.php';</script>";
                            exit();
                        } else {
                            echo "<script>alert('Error addition user: " . $conn->error . "')</script>";
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
    }
    if ($position == 'Professor') {
        $oppositePosition = 'Student';
    } else {
        $oppositePosition = 'Professor';
    }
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
                <li><a href='<?php echo $homeDir ?>'>Home</a></li>
                <li><a href="#" class='active'>Users</a></li>
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
        <div class="container">
            <div class="users">
                <h2 class="users-title">User List</h2>
                <div class="table-container">
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
                <hr class="seperator">
                <form action="" method="post" class="edit-delete">
                    <div class='input-group'>
                        <p>ID</p>
                        <input type="text" placeholder="ID" name="id" value="<?php echo $id; ?>" required>
                    </div>

                    <div class='input-group'>
                        <p>Name:</p>
                        <input type="text" placeholder="Name" name="name" value="<?php echo $name2; ?>">
                    </div>

                    <div class='input-group'>
                        <p>Email:</p>
                        <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
                    </div>

                    <div class='input-group'>
                        <p>Password:</p>
                        <input type="password" placeholder="Password" name="password" id="password" value="<?php echo $password; ?>">
                    </div>

                    <div class='input-group'>
                        <p>Gender:</p>
                        <input type="text" placeholder="Gender" name="gender" value="<?php echo $gender; ?>">
                    </div>

                    <div class='input-group'>
                        <p>Birthday:</p>
                        <input type="date" placeholder="Birthday" name="birthday" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $birthday; ?>">
                    </div>

                    <div class='input-group'>
                        <p>Position:</p>
                        <select id="positionSelectUser" name="position" required>
                            <option value="Student"><?php echo $position; ?></option>
                            <option value="Professor"><?php echo $oppositePosition; ?></option>
                        </select>
                    </div>

                    <div class='interests'>
                        <p>Interests:</p>
                        <input type="checkbox" id="mathU" name="interests[]" value="Math" <?php if (in_array('Math', explode(', ', $interests))) echo 'checked'; ?>> <!-- merr vleren e interesit qe mund te jete "Math, Science" dhe e ban split/pren me presje dhe nese eshte vlera Math aty e ban check, ngjashem me te tjerat -->
                        <label for="math">Math</label>
                        <input type="checkbox" id="sportsU" name="interests[]" value="Sports" <?php if (in_array('Sports', explode(', ', $interests))) echo 'checked'; ?>>
                        <label for="sports">Sports</label>
                        <input type="checkbox" id="scienceU" name="interests[]" value="Science" <?php if (in_array('Science', explode(', ', $interests))) echo 'checked'; ?>>
                        <label for="science">Science</label>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="getUser" name="getUser">Get User</button>
                        <button type="submit" class="addUser" name="addUser">Add User</button>
                        <button type="submit" class="editUser" name="editUser">Edit User</button>
                        <button type="submit" class="deleteUser" name="deleteUser">Delete User</button>
                    </div>
                </form>

            </div>
        </div>

        <?php
        $conn->close();
        ?>
    </div>
    <script src="script.js"></script>
</body>

</html>