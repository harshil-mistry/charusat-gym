<?php
session_start();

if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
    header('Location: admin');
    exit();
}

include("config.php");
include("countnotification.php");

if (isset($_SESSION['newalert'])) {
    echo "<script>alert('" . $_SESSION['newalert'] . "');</script>";
    unset($_SESSION['newalert']);
}

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
}


// Array of quotes
$quotes = [
    ["The future belongs to those who believe in the beauty of their dreams.", "Eleanor Roosevelt"],
    ["Education is the most powerful weapon which you can use to change the world.", "Nelson Mandela"],
    ["The only way to do great work is to love what you do.", "Steve Jobs"],
    ["Believe you can and you're halfway there.", "Theodore Roosevelt"],
    ["Your time is limited, don't waste it living someone else's life.", "Steve Jobs"]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Achieve your fitness goals at Charusat University Gym. Explore membership plans, expert workout guides, and diet plans. Join today for a healthier lifestyle!">
    <meta name="keywords" content="Charusat gym, Charusat university fitness, Charusat fitness hub, Charusat gym membership, workout plans">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charusat Gym</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/index.css">
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a class="active-nav" href="#home">Home</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="subscription">Membership</a></li>
                <li><a href="guide">Guide</a></li>
                <li><a href="notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                echo "(" . $notificationCount . ")";
                                                            } ?></a></li>
                <li><a href="about-us">About Us</a></li>
                <?php if (isset($_SESSION["id"])) { ?>
                    <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                    <script>
                        function logout() {
                            if (confirm("Are you sure you want to logout?")) {
                                window.location.href = "logout.php";
                            }
                        }
                    </script>
                <?php } else { ?>
                    <li><a href="login">Login</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="hero-content">
                <h1>Welcome to Charusat Gym<?php if (isset($name)) {
                                                echo ", " . $name;
                                            } ?>!</h1>
                <p>Start your physical fitness journey with us and become the best version of yourself</p>
                <?php if (isset($_SESSION['id'])) { ?>
                    <a href="profile" class="cta-button">View profile</a>
                <?php } else { ?>
                    <a href="login" class="cta-button">Register Now</a>
                <?php } ?>
            </div>
        </section>

        <div class="container2">
            <p>Let's get<br> <span>#<span id="DynamicText">Stronger</span>|</span><br> together</p>
        </div>

        <section class="quotes">
            <div class="container">
                <h2>Words of Wisdom</h2>
                <div class="quote-slider">
                    <?php foreach ($quotes as $index => $quote): ?>
                        <div class="quote <?php echo $index === 0 ? 'active' : ''; ?>">
                            <p>"<?php echo $quote[0]; ?>"</p>
                            <cite>- <?php echo $quote[1]; ?></cite>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <div class="feature-grid">
                    <div class="feature-item">
                        <h2 style="padding-top:1rem;">Premium plan benefits</h2>
                        <div class="features-content">
                            <ul>
                                <li><span class="material-symbols-outlined greencheck">
                                        done_outline
                                    </span> Gym Access
                                </li>
                                <li><span class="material-symbols-outlined greencheck">
                                        done_outline
                                    </span> 1 hour Time-slot
                                </li>
                                <li><span class="material-symbols-outlined greencheck">
                                        done_outline
                                    </span> Trainer Consultancy
                                </li>
                                <li><span class="material-symbols-outlined greencheck">
                                        done_outline
                                    </span> Workout Plan
                                </li>
                                <li><span class="material-symbols-outlined greencheck">
                                        done_outline
                                    </span> Personalised Diet Plan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="plans-btn"><a href="subscription" class="cta-button">Explore Now</a></div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Charusat Gym | All rights reserved | Designed with ❤️ for students by students !! 😊</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var DynamicText = document.getElementById("DynamicText");
            var texts = ["Stronger", "Better", "Fit"];
            var currentIndex = 0;

            function clearText(index) {
                setTimeout(function() {
                    var currentText = DynamicText.textContent;
                    var updatedText = currentText.substring(
                        0,
                        currentText.length - index
                    );
                    DynamicText.textContent = updatedText;

                    if (index < currentText.length) {
                        clearText(index + 1);
                    } else {
                        // Start displaying the next text
                        currentIndex = (currentIndex + 1) % texts.length;
                        displayText(texts[currentIndex], 0);
                    }
                }, 100);
            }

            function displayText(targetText, index) {
                setTimeout(function() {
                    var updatedText = targetText.substring(0, index + 1);
                    DynamicText.textContent = updatedText;

                    if (index < targetText.length - 1) {
                        displayText(targetText, index + 1);
                    } else {
                        // Clear the text after a brief pause
                        setTimeout(function() {
                            clearText(0);
                        }, 500);
                    }
                }, 100);
            }

            // Start the loop
            clearText(0);
        });

        // Quote slider
        const quotes = document.querySelectorAll('.quote');
        let currentQuote = 0;

        function showNextQuote() {
            quotes[currentQuote].classList.remove('active');
            currentQuote = (currentQuote + 1) % quotes.length;
            quotes[currentQuote].classList.add('active');
        }

        setInterval(showNextQuote, 5000);


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