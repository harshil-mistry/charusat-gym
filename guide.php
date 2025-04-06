<?php
session_start();

include ("config.php");
include ("countnotification.php");


if (!isset($_SESSION["id"])) {
    $_SESSION['newalert'] = "You need to login to access this page!";
    header('Location: login');
    exit();
}

if ($_SESSION['type'] == 'admin') {
    $_SESSION['newalert'] = 'Only students can access their page!';
    header('Location: /admin');
    exit();
}

$userid = $_SESSION['id'];
$sql = "SELECT `gender` FROM profiles WHERE studentid='$userid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$gender = $row['gender'];

$sql = "SELECT slot FROM subscriptions WHERE `studentid`='" . $_SESSION['id'] . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);

if($row == 0 && $gender!="Female")
{
    $_SESSION['newalert'] = "Only premium users can access this page!";
    header('Location: subscription');
    exit();
}

if (isset($_SESSION['newalert'])) {
    echo "<script>alert('" . $_SESSION['newalert'] . "');</script>";
    unset($_SESSION['newalert']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Personalized workout and diet plans for bulking, cutting, or maintenance. Achieve your fitness goals with expert guidance from Charusat Gym.">
    <meta name="keywords" content="Charusat gym guide, workout plans, diet plans, fitness goals">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide</title>
    <link rel="stylesheet" href="static/css/guide.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
                <li><a href="#" class="active-nav">Guide</a></li>
                <li><a href="/notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                        echo "(" . $notificationCount . ")";
                                                                    } ?></a></li>
                <li><a href="/about-us">About Us</a></li>
                <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                <script>
                    function logout() {
                        if (confirm("Are you sure you want to logout?")) {
                            window.location.href = "/logout.php";
                        }
                    }
                </script>
            </ul>
        </nav>
    </header>

    <main class="maincontainer">
        <div class="section">
            <h2>6-Day Workout Plan</h2>
            <div class="workout-day">
                <h3>Monday - Chest</h3>
                <p>Bench Press : 3 x 8-12 reps</p>
                <p>Inclined Bench Press : 3 x 8-12 reps</p>
                <p>Pec Fly : 3 x 8-12 reps</p>
            </div>
            <div class="workout-day">
                <h3>Tuesday - Back</h3>
                <p>Chest supported Rows : 4 x 10-12 reps</p>
                <p>Lat pulldowns : 3 x 8-12 reps</p>
                <p>Seated Cable Rows : 3 x 8-12 reps</p>
                <p>Shrugs : 2 x 8-10 reps</p>
            </div>
            <div class="workout-day">
                <h3>Wednesday - Legs</h3>
                <p>Smith machine Squats : 3 x 10-14 reps</p>
                <p>Leg Press : 3 x 10-14 reps</p>
                <p>RDLs : 2 x 8-12 reps</p>
                <p>Calf Raises : 3 x 10-12 reps</p>
            </div>
            <div class="workout-day">
                <h3>Thursday - Shoulders</h3>
                <p>Machine Shoulder Press : 3 x 8-12 reps</p>
                <p>Lateral Raises : 4 x 8-12 reps</p>
                <p>Face pulls : 3 x 8-12 reps</p>
            </div>
            <div class="workout-day">
                <h3>Friday - Arms</h3>
                <p>Bicep Preacher Curls : 3 x 8-12 reps</p>
                <p>Overhead Tricep Extensions : 3 x 8-12 reps</p>
                <p>Hammer Curls : 3 x 8-12 reps</p>
                <p>Tricep pulldowns : 3 x 10-14 reps</p>
                <p>Forearm Curls : 3 x 12-16 reps</p>
            </div>
            <div class="workout-day">
                <h3>Saturday - Cardio / Rest Day</h3>
                <p>You can rest or do cardio on saturday as per your fitness goals.</p>
            </div>
        </div>

        <div class="section">
            <h2>Diet Plan</h2>
            <select id="dietSelect">
                <option value="">Select your goal</option>
                <option value="bulking">Bulking</option>
                <option value="cutting">Cutting</option>
                <option value="fitness">General Fitness</option>
                <option value="maintenance">Maintenance</option>
            </select>

            <div id="bulking" class="diet-plan">
                <h3>Bulking Diet Plan</h3>
                <p>High calorie, protein-rich diet to support muscle growth.</p>
                <ul>
                    <li>Increase calorie intake by 300-500 calories above maintenance</li>
                    <li>Consume 1.6-2.2 grams of protein per kg of body weight</li>
                    <li>Include complex carbohydrates and healthy fats</li>
                    <li>Eat frequent meals throughout the day</li>
                </ul>
            </div>

            <div id="cutting" class="diet-plan">
                <h3>Cutting Diet Plan</h3>
                <p>Calorie-deficit diet to reduce body fat while maintaining muscle.</p>
                <ul>
                    <li>Reduce calorie intake by 300-500 calories below maintenance</li>
                    <li>Maintain high protein intake (1.6-2.2 grams per kg of body weight)</li>
                    <li>Reduce carbohydrate and fat intake</li>
                    <li>Focus on nutrient-dense, low-calorie foods</li>
                </ul>
            </div>

            <div id="fitness" class="diet-plan">
                <h3>General Fitness Diet Plan</h3>
                <p>Balanced diet to support overall health and fitness.</p>
                <ul>
                    <li>Maintain a balanced calorie intake</li>
                    <li>Include a variety of fruits, vegetables, lean proteins, and whole grains</li>
                    <li>Stay hydrated with water and low-calorie beverages</li>
                    <li>Limit processed foods and added sugars</li>
                </ul>
            </div>

            <div id="maintenance" class="diet-plan">
                <h3>Maintenance Diet Plan</h3>
                <p>Diet to maintain current body composition and support performance.</p>
                <ul>
                    <li>Consume calories at maintenance level</li>
                    <li>Balance macronutrients according to activity level</li>
                    <li>Focus on whole, nutrient-dense foods</li>
                    <li>Adjust intake based on changes in body composition or performance</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <div>
            <p>&copy; <?php echo date("Y"); ?> Charusat Gym | All rights reserved | Designed with ❤️ for students by students !! 😊</p>
        </div>
    </footer>

    <script>
        document.getElementById('dietSelect').addEventListener('change', function() {
            var selectedPlan = this.value;
            var dietPlans = document.getElementsByClassName('diet-plan');

            for (var i = 0; i < dietPlans.length; i++) {
                dietPlans[i].classList.remove('active');
            }

            if (selectedPlan) {
                document.getElementById(selectedPlan).classList.add('active');
            }
        });
    </script>

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