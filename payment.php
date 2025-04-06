<?php

session_start();
include("config.php");
include("countnotification.php");

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

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['newalert'] = 'Invalid access!';
    header('Location: /');
    exit();
}
$type = $_POST['type'];
$duration = $_POST['duration'];
if ($type == "student") {
    if ($duration == '3') {
        $totalAmount = 300;
    } else if ($duration == '6') {
        $totalAmount = 600;
    } else {
        $totalAmount = 1000;
    }
} else {
    if ($duration == '3') {
        $totalAmount = 750;
    } else if ($duration == '6') {
        $totalAmount = 1300;
    } else {
        $totalAmount = 2500;
    }
}
$weight = $_POST['weight'];
$goal = $_POST['goal'];
$orderID = $_SESSION['id'] . '_' . date('d/m/Y') . '_' . $totalAmount;
$id = $_SESSION['id'];

$sql = "SELECT email, contact FROM profiles WHERE studentid='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
$contact =  "+91".$row['contact'];
$slots = array();
$sql = "SELECT capacity FROM slots";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    array_push($slots,   $row['capacity']);
}

$maxcapacity = 50;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Summary</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/payment.css">
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="subscription" class="active-nav">Membership</a></li>
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
        <div class="payment-card">
            <h1>Payment Summary</h1>
            <div class="payment-details">
                <div class="payment-item">
                    <span class="label">Duration:</span>
                    <span class="value"><?php echo htmlspecialchars($duration);
                                        echo ($duration == 1) ? " month" : " months"; ?></span>
                </div>
                <div class="payment-item">
                    <span class="label">Weight:</span>
                    <span class="value"><?php echo htmlspecialchars($weight); ?> kg</span>
                </div>
                <div class="payment-item">
                    <span class="label">Goal:</span>
                    <span class="value"><?php echo htmlspecialchars(ucfirst($goal)); ?></span>
                </div>
                <div class="payment-item">
                    <span class="label">Time Slot:</span>
                    <select id="slot">
                        <option value="1" <?php if ($slots[0] >= $maxcapacity) echo "disabled" ?>>06:00 AM - 07:00 AM</option>
                        <option value="2" <?php if ($slots[1] >= $maxcapacity) echo "disabled" ?>>07:00 AM - 08:00 AM</option>
                        <option value="3" <?php if ($slots[2] >= $maxcapacity) echo "disabled" ?>>08:00 AM - 09:00 AM</option>
                        <option value="4" <?php if ($slots[3] >= $maxcapacity) echo "disabled" ?>>04:30 PM - 05:30 PM</option>
                        <option value="5" <?php if ($slots[4] >= $maxcapacity) echo "disabled" ?>>05:30 PM - 06:30 PM</option>
                        <option value="6" <?php if ($slots[5] >= $maxcapacity) echo "disabled" ?>>06:30 PM - 07:30 PM</option>
                    </select>
                </div>
                <div class="payment-item total-amount">
                    <span class="label">Total Amount:</span>
                    <span class="value">₹<?php echo htmlspecialchars($totalAmount); ?></span>
                </div>
            </div>
            <div class="button-group">
                <a href="subscription.php" class="btn btn-secondary">Back to Subscriptions</a>
                <!-- This form is the payment button-->
                <form action="handlepayment.php" method="POST">
                    <script
                        src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="rzp_live_JXqlMkYvWKZBZZ"     //"rzp_test_stRxDzon03eblF" // API key
                        data-amount=100//<?php echo $totalAmount * 100 ?> // Amount is in paisa
                        data-currency="INR" //
                        data-id="<?php echo $orderID ?>" // Order ID generated in background
                        data-buttontext="Pay ₹<?php echo $totalAmount; ?>"
                        data-name="Charusat Fitness Center"
                        data-image="https://admission.charusat.ac.in/View%20Assets/images/University_Hero.png"
                        data-prefill.name="<?php echo $_SESSION['name'] ?>"
                        data-prefill.email="<?php echo $email ?>"
                        data-prefill.contact="<?php echo $contact ?>"
                        data-theme.color="#333333">
                    </script>
                    <input type="hidden" name="name" value="<?php echo $_SESSION['name'] ?>" />
                    <input type="hidden" name="slotvalue" id="slotvalue" value="1">
                    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>" />
                    <input type="hidden" name="amount" value="<?php echo $totalAmount ?>" />
                    <input type="hidden" name="orderid" value="<?php echo $orderID ?>" />
                    <input type="hidden" name="duration" value="<?php echo $duration ?>" />
                </form>
                <script>
                    function updateSlotValue() {
                        const dropdown = document.getElementById('slot');
                        const slotValueInput = document.getElementById('slotvalue');
                        slotValueInput.value = dropdown.value;
                    }
                    document.getElementById('slot').addEventListener('change', updateSlotValue);
                </script>
            </div>
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
    </script>
    <script src="inspect.js"></script>
</body>

</html>