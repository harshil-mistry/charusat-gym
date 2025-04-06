<?php
session_start();
include("config.php");

if (!$conn) {
    die("Connection failed: ");
}

if (!isset($_SESSION['id'])) {
    $subscribed = false;
    $gender = "Male";
} else {
    $id =  $_SESSION['id'];
    $sql = "SELECT slot FROM subscriptions WHERE `studentid` = '$id'";
    $result = mysqli_query($conn, $sql);
    $temp = mysqli_num_rows($result);
    if ($temp != 0) {
        $subscribed = true;
    } else {
        $subscribed = false;
    }
    $sql = "SELECT `gender` FROM profiles WHERE `studentid` = '$id'";
    $result = mysqli_query($conn, $sql);
    $temp = mysqli_fetch_assoc($result);
    $gender = $temp['gender'];
}

if ($subscribed || $gender=="Female") {
    $sql = "SELECT * FROM notifications ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM notifications WHERE `target`='all' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
}
$notificationCount = mysqli_num_rows($result);

$announcements = array();
if ($notificationCount != 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($announcements, $row);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Stay updated with the latest gym announcements, events, and offers from Charusat University Gym. Don’t miss out!">
    <meta name="keywords" content="Charusat gym notifications, gym announcements, fitness updates">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/notification.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>Notifications</title>
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/subscription">Membership</a></li>
                <li><a href="/guide">Guide</a></li>
                <li><a class="active-nav" href="#">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                    echo "(" . $notificationCount . ")";
                                                                } ?></a></li>
                <li><a href="/about-us">About Us</a></li>
                <?php if (isset($_SESSION["id"])) { ?>
                    <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                    <script>
                        function logout() {
                            if (confirm("Are you sure you want to logout?")) {
                                window.location.href = "/logout.php";
                            }
                        }
                    </script>
                <?php } else { ?>
                    <li><a href="/login">Login</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main class="maincontainer">
        <h1>Gym Announcements</h1>

        <div id="announcements">
            <?php if (empty($announcements)) { ?>
                <div class="no-announcements">No live announcements to show</div>
            <?php } else { ?>
                <h3 style="margin: 1rem 0;">Live announcements :</h3>
                <?php foreach ($announcements as $announcement) { ?>
                    <div class="announcement" data-id="<?php echo $announcement['id']; ?>">
                        <p><?php echo ucfirst(htmlspecialchars($announcement['notification'])); ?></p>
                    </div>
            <?php }
            } ?>
        </div>
    </main>

    <footer>
        <div>
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
    </script>
    <script src="inspect.js"></script>
</body>

</html>