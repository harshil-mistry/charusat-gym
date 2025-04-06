<?php
session_start();

if (!isset($_SESSION["id"])) {
    $_SESSION['newalert'] = 'You need to login to access this page!';
    header('Location: login');
    exit();
}

if ($_SESSION['type'] == 'admin') {
    $_SESSION['newalert'] = 'Only students can access their page!';
    header('Location: admin');
    exit();
}

include("config.php");
include("countnotification.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $ename = mysqli_real_escape_string($conn, $_POST['ename']);
    $erelation = mysqli_real_escape_string($conn, $_POST['erelation']);
    $econtact = mysqli_real_escape_string($conn, $_POST['econtact']);

    if ((strlen($contact) != 10) || strlen($econtact) != 10 || $contact < 0 || $econtact < 0) {
        $message = "Please enter a valid 10 digit contact number";
    } elseif ($contact == $econtact) {
        $message = "Contact number and emergency contact number cannot be same !!";
    } else {
        $sql = "UPDATE profiles SET `address`='$address', `city`='$city', `pincode`='$pincode', `contact`='$contact', `email`='$email', `dob`='$dob', `ename`='$ename', `erelation`='$erelation', `econtact`='$econtact' WHERE studentid='$id'";
        mysqli_query($conn, $sql);
        $message = "Profile updated successfully!";
    }
}

if (isset($message)) {
    echo '<script>alert("' . $message . '");</script>';
    unset($message);
}

$sql = "SELECT * FROM profiles WHERE studentid='$id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

$image = $student['passport'];
$base64Image = 'data:image/jpeg;base64,' . base64_encode($image);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View and update your details, manage your subscription, and keep your fitness journey on track with your Charusat Gym profile.">
    <meta name="keywords" content="Charusat gym profile, user account, edit gym details">
    <meta name="author" content="Charusat University Gym Team">
    <title>Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/profile.css">
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a class="active-nav">Profile</a></li>
                <li><a href="subscription">Membership</a></li>
                <li><a href="guide">Guide</a></li>
                <li><a href="notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                echo "(" . $notificationCount . ")";
                                                            } ?></a></li>
                <li><a href="about-us">About Us</a></li>
                <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                <script>
                    function logout() {
                        if (confirm("Are you sure you want to logout?")) {
                            window.location.href = "logout";
                        }
                    }
                </script>
            </ul>
        </nav>
    </header>

    <main>
        <div class="profile-card">
            <h1>Student Profile</h1>
            <div class="profile-details" id="profile-details">

                <div class="profile-item image-div">
                        <img src="<?php echo $base64Image; ?>" alt="Student Image" class="profile-image">
                    </div>

                <div class="profile-item">
                    <label>Name:</label>
                    <p><?php echo htmlspecialchars($student['name']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Student ID:</label>
                    <p><?php echo htmlspecialchars($student['studentid']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Institute:</label>
                    <p><?php echo htmlspecialchars($student['institute']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Department:</label>
                    <p><?php echo htmlspecialchars($student['department']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Role:</label>
                    <p><?php echo htmlspecialchars(ucfirst($student['type'])); ?></p>
                </div>

                <div class="profile-item">
                    <label>Address:</label>
                    <p><?php echo htmlspecialchars($student['address']); ?></p>
                </div>

                <div class="profile-item">
                    <label>City:</label>
                    <p><?php echo htmlspecialchars($student['city']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Pincode:</label>
                    <p><?php echo htmlspecialchars($student['pincode']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Gender:</label>
                    <p><?php echo htmlspecialchars($student['gender']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Contact:</label>
                    <p><?php echo htmlspecialchars($student['contact']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Email:</label>
                    <p><?php echo htmlspecialchars($student['email']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Date of Birth:</label>
                    <p><?php echo htmlspecialchars(date("d-m-Y", strtotime($student['dob']))); ?></p>
                </div>

                <div class="profile-item">
                    <label>Emergency Contact Name:</label>
                    <p><?php echo htmlspecialchars($student['ename']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Emergency Contact Relation:</label>
                    <p><?php echo htmlspecialchars($student['erelation']); ?></p>
                </div>

                <div class="profile-item">
                    <label>Emergency Contact Number:</label>
                    <p><?php echo htmlspecialchars($student['econtact']); ?></p>
                </div>
            </div>

            <div class="profile-form" id="profile-form">

                <form id="edit-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="profile-item">
                        <label for="name">Name:</label>
                        <input type="text" class="non-editable" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="studentid">Student ID:</label>
                        <input type="text" class="non-editable" name="studentid" value="<?php echo htmlspecialchars($student['studentid']); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="institute">Institute:</label>
                        <input type="text" class="non-editable" name="institute" value="<?php echo htmlspecialchars($student['institute']); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="department">Department:</label>
                        <input type="text" class="non-editable" name="department" value="<?php echo htmlspecialchars($student['department']); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="role">Role:</label>
                        <input type="text" class="non-editable" name="role" value="<?php echo htmlspecialchars(ucfirst($student['type'])); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="address">Address:</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($student['address']); ?>" required>
                    </div>

                    <div class="profile-item">
                        <label for="city">City:</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($student['city']); ?>" required>
                    </div>

                    <div class="profile-item">
                        <label for="pincode">Pincode:</label>
                        <input type="number" name="pincode" value="<?php echo htmlspecialchars($student['pincode']); ?>" maxlength="6" required
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    </div>

                    <div class="profile-item">
                        <label for="gender">Gender:</label>
                        <input type="text" class="non-editable" name="gender" value="<?php echo htmlspecialchars(ucfirst($student['gender'])); ?>" readonly>
                    </div>

                    <div class="profile-item">
                        <label for="contact">Contact:</label>
                        <input type="number" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>" maxlength="10" required
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    </div>

                    <div class="profile-item">
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                    </div>

                    <div class="profile-item">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                    </div>

                    <div class="profile-item">
                        <label for="ename">Emergency Contact Name:</label>
                        <input type="text" name="ename" value="<?php echo htmlspecialchars($student['ename']); ?>" required>
                    </div>

                    <div class="profile-item">
                        <label for="erelation">Emergency Contact Relation:</label>
                        <select name="erelation">
                            <option value="Father" <?php echo $student['erelation'] == 'Father' ? 'selected' : ''; ?>>Father</option>
                            <option value="Mother" <?php echo $student['erelation'] == 'Mother' ? 'selected' : ''; ?>>Mother</option>
                            <option value="Brother" <?php echo $student['erelation'] == 'Brother' ? 'selected' : ''; ?>>Brother</option>
                            <option value="Sister" <?php echo $student['erelation'] == 'Sister' ? 'selected' : ''; ?>>Sister</option>
                            <option value="Friend" <?php echo $student['erelation'] == 'Friend' ? 'selected' : ''; ?>>Friend</option>
                            <option value="Other" <?php echo $student['erelation'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="profile-item">
                        <label for="econtact">Emergency Contact Number:</label>
                        <input type="number" name="econtact" value="<?php echo htmlspecialchars($student['econtact']); ?>" maxlength="10" required
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    </div>

                    <div class="warning">Note : Contact sports department if you want to edit name, student id, profile image, institute, department or Role</div>

                    <button class="save-button" type="submit">Save Changes</button>
                    <button class="cancel-button" type="button" onclick="cancelEdit()">Cancel</button>
                </form>
            </div>
            <button class="edit-button" onclick="toggleEdit()">Edit Profile</button>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Charusat Gym | All rights reserved | Designed with ❤️ for students by students !! 😊</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Edit profile functionality
        function toggleEdit() {
            document.getElementById('profile-details').style.display = 'none';
            document.getElementById('profile-form').style.display = 'block';
            document.querySelector('.edit-button').style.display = 'none';
            document.querySelector('.save-button').style.display = 'inline-block';
            document.querySelector('.cancel-button').style.display = 'inline-block';
        }

        function cancelEdit() {
            document.getElementById('profile-details').style.display = 'block';
            document.getElementById('profile-form').style.display = 'none';
            document.querySelector('.edit-button').style.display = 'inline-block';
            document.querySelector('.save-button').style.display = 'none';
            document.querySelector('.cancel-button').style.display = 'none';
        }
    </script>
    <script src="inspect.js"></script>
</body>

</html>