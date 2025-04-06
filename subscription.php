<?php
session_start();

include("config.php");

$sql = "DELETE from subscriptions WHERE `expiry`<=NOW()";
mysqli_query($conn, $sql);

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

if (isset($_SESSION['newalert'])) {
    echo '<script>alert("' . $_SESSION['newalert'] . '");</script>';
    unset($_SESSION['newalert']);
}

include("countnotification.php");

$userid = $_SESSION["id"];
$sql = "SELECT * FROM subscriptions WHERE `studentid`='$userid'";
$detail = mysqli_query($conn, $sql);
if (mysqli_num_rows($detail) == 1) {
    $subscribed = true;
    $details = mysqli_fetch_assoc($detail);
} else {
    $subscribed = false;
}

$female = false;

$sql = "SELECT `gender`, `type`, `name`, `ename`, `econtact` FROM profiles WHERE studentid='$userid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$gender = $row['gender'];
$type = $row['type'];
if ($gender == 'Female') {
    $subscribed = true;
}

if ($row['type'] == "student") {
    $price = [300, 600, 1000];
} else {
    $price = [750, 1300, 2500];
}

$slots = [
    '1' => '06:00 AM to 07:00 AM',
    '2' => '07:00 AM to 08:00 AM',
    '3' => '08:00 AM to 09:00 AM',
    '4' => '04:30 PM to 05:30 PM',
    '5' => '05:30 PM to 06:30 PM',
    '6' => '06:30 PM to 07:30 PM',
];

// Subscription details
$subscriptions = [
    'premium' => [
        'name' => 'Premium',
        'price' => $price,
        'features' => [
            'Gym Access',
            '1 Hour Time Slot',
            'Personalized Diet Plan',
            'Workout Guide',
            'Advanced Facilities',
            'Trainer Consultation',
            'Locker Access'
        ]
    ]
];

// Duration options
$durations = [
    '3' => '3 Months',
    '6' => '6 Months',
    '12' => '12 Months'
];

// Goals
$goals = ['Bulking', 'Cutting', 'Maintenance', 'General Fitness', 'Strength Training'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Buy a Charusat Gym membership or download your subscription card. Affordable plans to meet your fitness goals. Subscribe now!">
    <meta name="keywords" content="Charusat gym membership, buy subscription, gym subscription card">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/subscription.css">
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="#" class="active-nav">Membership</a></li>
                <li><a href="guide">Guide</a></li>
                <li><a href="notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                        echo "(" . $notificationCount . ")";
                                                                    } ?></a></li>
                <li><a href="about-us">About Us</a></li>
                <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                <script>
                    function logout() {
                        if (confirm("Are you sure you want to logout?")) {
                            window.location.href = "logout.php";
                        }
                    }
                </script>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Elevate Your Fitness Journey</h1>
                <p>Join Charusat's premium gym facilities and take your health to the next level. Check out premium plan to start your journey.</p>
                <a href="#subscribe" class="cta-button">Get Started Now</a>
            </div>
        </section>

        <?php if ($subscribed) { ?>

            <div class="gym-card">
                <h1 style="margin-bottom: 1rem;">Download Gym Card</h1>
                
                <?php

                $sql = "SELECT gender FROM profiles WHERE `studentid`='$userid'";
                $result = mysqli_query($conn, $sql);
                $tempres = mysqli_fetch_array($result);
                $gender = $tempres[0];
                if($gender == 'Male'){
                    $sql = mysqli_query($conn, " SELECT card FROM subscriptions WHERE `studentid`='$userid'");
                } else {
                    $sql = mysqli_query($conn, " SELECT card FROM female WHERE `studentid`= '$userid'");
                }
                $row = mysqli_fetch_array($sql);
                if($row){
                $image = $row[0];
                $base64Image = 'data:image/jpeg;base64,' . base64_encode($image);
                } else{
                    $base64Image = 'abcd';
                }


                ?>
                
                <img src="<?php echo $base64Image; ?>" alt="Gym Card" style="width: 100%; margin: 1rem auto;;">

                <button onclick="download()" class="download-btn">Download</button>

                <script>
                    function download() {
                        window.location.href = 'download.php?id=<?php echo $userid; ?>';
                    }
                </script>

                

            </div>
            </div>

        <?php } else { ?>

            <section class="container subscription-comparison">
                <?php foreach ($subscriptions as $key => $subscription): ?>
                    <div class="subscription-card">
                        <h2><?php echo $subscription['name'] . " plan"; ?></h2>
                        <h3>Pricing :</h3>
                        <p class="price">₹<?php echo $price[0]; ?> <span style="font-size: 1rem;">/ 3 months</span></p>
                        <p class="price">₹<?php echo $price[1]; ?> <span style="font-size: 1rem;">/ 6 months</span></p>
                        <p class="price">₹<?php echo $price[2]; ?> <span style="font-size: 1rem;">/ 12 months</span></p>
                        <h3>Features :</h3>
                        <ul>
                            <?php foreach ($subscription['features'] as $feature): ?>
                                <li><?php echo $feature; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </section>

            <section class="testimonials">
                <div class="container">
                    <h2>Why Choose Charusat Gym?</h2>
                    <div class="feature-grid">
                        <div class="feature">
                            <h3>Advanced Equipment</h3>
                            <p>Access to the latest fitness technology and machines</p>
                        </div>
                        <div class="feature">
                            <h3>Expert Trainer</h3>
                            <p>Guidance from fitness professionals</p>
                        </div>
                        <div class="feature">
                            <h3>Flexible Timings</h3>
                            <p>Choose time slots that fit your busy student life</p>
                        </div>
                        <div class="feature">
                            <h3>Supportive Community</h3>
                            <p>Connect with like-minded fitness enthusiasts</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="subscribe" class="subscription-form">
                <h2>Subscribe Now</h2>
                <form id="subscriptionForm" action="payment" onsubmit="return validateForm()" method="post">
                    <div class="form-group">
                        <label for="weight">Weight (kg):</label>
                        <input type="number" id="weight" name="weight" required>
                    </div>
                    <div class="form-group">
                        <label for="goal">Fitness Goal:</label>
                        <select id="goal" name="goal" required>
                            <option value="">Select your goal</option>
                            <?php foreach ($goals as $goal): ?>
                                <option value="<?php echo strtolower($goal); ?>"><?php echo $goal; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="duration">Subscription Duration:</label>
                        <select id="duration" name="duration" required>
                            <option value="">Select duration</option>
                            <?php foreach ($durations as $key => $duration): ?>
                                <option value="<?php echo $key; ?>"><?php echo $duration; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="<?php echo $type ?>">
                    <button type="submit" class="submit-btn">Start Your Fitness Journey</button>
                </form>
            </section>

        <?php } ?>

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

        // Form validation
        function validateForm() {
            const weight = document.getElementById('weight').value;
            const goal = document.getElementById('goal').value;
            const subscriptionType = document.getElementById('subscriptionType').value;
            const duration = document.getElementById('duration').value;

            if (!weight || !goal || !subscriptionType || !duration) {
                alert('Please fill in all fields');
                return false;
            }

            return true;
        }
    </script>
    <script src="inspect.js"></script>
</body>

</html>