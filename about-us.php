<?php

session_start();

include("config.php");
include("countnotification.php");

$team_members = [
    [
        "name" => "Harshil Mistry",
        "role" => "Full Stack Developer",
        "bio" => "Harshil is our full stack wizard, bringing both front-end flair and back-end muscle to our platform.",
        "image" => "static/harshil.jpeg",
        "linkedin" => "https://www.linkedin.com/in/harshilmistry295/"
    ],
    [
        "name" => "Dharmil Gadhiya",
        "role" => "Frontend Designer",
        "bio" => "Dharmil crafts our user experience, ensuring every interaction on our site is as smooth as your workout routine.",
        "image" => "static/dharmil.jpg",
        "linkedin" => "https://www.linkedin.com/in/dharmil-gadhiya-912031223/"
    ],
    [
        "name" => "Meet Borkhatariya",
        "role" => "Research",
        "bio" => "Leading the way in research, Meet ensures that our platform is always ahead of the curve.",
        "image" => "static/meet.jpeg",
        "linkedin" => "https://www.linkedin.com/in/meet-borkhatariya-36755030b/"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Learn more about Charusat University Gym, our facilities, and the team behind the website. Contact us or explore our gym gallery.">
    <meta name="keywords" content="Charusat gym about us, contact information, gym gallery, gym developers">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="static/css/about-us.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e85db21e83.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="container">
            <a href="#" class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="subscription">Membership</a></li>
                <li><a href="guide">Guide</a></li>
                <li><a href="notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                        echo "(" . $notificationCount . ")";
                                                                    } ?></a></li>
                <li><a class="active-nav" href="#">About Us</a></li>
                <?php if (isset($_SESSION["id"])) { ?>
                    <li><a onclick="logout()" style="cursor:pointer;">Logout</a></li>
                    <script>
                        function logout() {
                            if (confirm("Are you sure you want to logout?")) {
                                window.location.href = "/logout";
                            }
                        }
                    </script>
                <?php } else { ?>
                    <li><a href="login">Login</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main class="maincontainer">

        <section class="contact-section">
            <h2>In case of any Queries</h2>
            <p> <i class="fa-solid fa-user"></i> : Dr. Pritesh Patel </p>
            <p> <i class="fa-solid fa-envelope"></i> : sports.officer@charusat.ac.in </p>
            <p> <i class="fa-solid fa-phone"></i> : +91-2697-265036</p>
        </section>

        <section class="about-section">
            <h2>Meet the Developers Behind Our Website</h2>
            <p>We’re the dedicated team behind Charusat Fitness Center’s digital experience, blending our passion for technology with a commitment to fitness. Our goal was to create a seamless, user-friendly platform that empowers members to connect, make progress, and achieve their goals—all with ease and efficiency.</p>

            <div class="team-grid">
                <?php
                foreach ($team_members as $member) {
                    echo "<div class='profile-card'>";
                    echo "<img src='{$member['image']}' alt='{$member['name']}' class='profile-image'>";
                    echo "<div class='profile-info'>";
                    echo "<h3>{$member['name']}</h3>";
                    echo "<p><h4>{$member['role']}</h4></p>";
                    echo "<p>{$member['bio']}</p>";
                    echo "<a href='{$member['linkedin']}' class='social-link' target='_blank'>LinkedIn Profile</a>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>

        <section class="gallery-section">
            <h2>A Glimpse of our Gym</h2>
            <div class="gallery-grid">
                <div class="subgrid">
                    <img src="static/gallery/Gallery9.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery4.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery12.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery8.jpg" alt="Gallery Image">
                </div>
                <div class="subgrid">
                    <img src="static/gallery/Gallery5.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery6.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery7.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery2.jpg" alt="Gallery Image">
                </div>
                <div class="subgrid">
                    <img src="static/gallery/Gallery10.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery1.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery11.jpg" alt="Gallery Image">
                    <img src="static/gallery/Gallery3.jpg" alt="Gallery Image">
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Charusat Gym | All rights reserved | Designed with ❤️ for students by students !! 😊</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileCards = document.querySelectorAll('.profile-card');

            profileCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });

        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
    <script src="inspect.js"></script>
</body>

</html>