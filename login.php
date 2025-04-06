<?php
session_start();

if (isset($_SESSION['id'])) {
    $_SESSION['newalert'] = 'You are already logged in!';
    if ($_SESSION['type'] == 'student') {
        $loc = '/';
    } else {
        $loc = 'admin';
    }
    header('Location: ' . $loc);
    exit();
}

include("config.php");
include ("countnotification.php");

if (isset($_SESSION['newalert'])) {
    echo '<script>alert("' . $_SESSION['newalert'] . '");</script>';
    unset($_SESSION['newalert']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="description" content="Access your Charusat University Gym account or register for a new membership. Manage your profile, view subscriptions, and start your fitness journey today.">
    <meta name="keywords" content="Charusat gym login, gym registration, account access, fitness portal">
    <meta name="author" content="Charusat University Gym Team">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./static/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="head-container">
            <a class="logo">Charusat Fitness Center</a>
            <div class="menu-toggle">☰</div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="profile">Profile</a></li>
                <li><a href="subscription">Membership</a></li>
                <li><a href="guide">Guide</a></li>
                <li><a href="notification">Notification <?php if (isset($notificationCount) && $notificationCount != 0) {
                                                                echo "(" . $notificationCount . ")";
                                                            } ?></a></li>
                <li><a href="about-us">About Us</a></li>
                <li><a class="active-nav" href="#">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-box" id="form-box">
        <div class="button-container">
            <button type="button" class="toggle-btn active-btn" id="login-btn" onclick="login()">Login</button>
            <button type="button" class="toggle-btn" id="register-btn" onclick="register()">Register</button>
        </div>
        <div class="login-container" id="login-container">
            <form action="checklogin.php" method="post">
                <input type="hidden" name="formtype" value="login">
                <input type="text" name="id" class="login-input" placeholder="Enter ID" required>
                <input type="password" id="pswd1" name="password" class="login-input" placeholder="Enter Password" required>
                <input type="checkbox" class="check-box" onclick="myFunction1()"><span>Show password</span>
                <div class="submit-cont"><button type="submit" class="submit-btn">Login</button></div>
                <script>
                    function myFunction1() {
                        var x1 = document.getElementById("pswd1");
                        if (x1.type === "password") {
                            x1.type = "text";
                        } else {
                            x1.type = "password";
                        }
                    }
                </script>
            </form>
        </div>
        <div class="register-container hidden" id="register-container">
            <form action="checklogin.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="formtype" value="register">
                <div class="sub1 sub">
                    <div class="sub1-1">
                        <div class="form-grp">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="form-grp">
                            <label>Middle Name</label>
                            <input type="text" name="mname" class="form-control" placeholder="Middle Name" required>
                        </div>

                        <div class="form-grp">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="form-grp">
                            <label>Student / Faculty</label>
                            <select class="form-control" name="type" required>
                                <option selected style="display:none;" value="0">Select Role</option>
                                <option value="student">Student</option>
                                <option value="faculty">Faculty</option>
                            </select>
                        </div>

                    </div>
                    <div class="sub1-2">

                        <div class="form-grp">
                            <label>Gender</label>
                            <select class="form-control" name="gender" required>
                                <option selected style="display:none;" value="0">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-grp">
                            <label>Student/Faculty ID</label>
                            <input type="text" name="studentid" class="form-control" placeholder="Student/Faculty ID" maxlength="15" required>
                        </div>

                        <div class="form-grp">
                            <label>Institite Name</label>
                            <input type="text" name="institute" class="form-control" placeholder="Institite Name" required>
                        </div>

                        <div class="form-grp">
                            <label>Department Name</label>
                            <input type="text" name="department" class="form-control" placeholder="Department Name" required>
                        </div>
                    </div>
                </div>

                <div class="sub2 sub">
                    <div class="address">
                        <label>Residential Address</label>
                        <textarea class="form-control" name="address" placeholder="Residential Address" rows="2" required></textarea>
                    </div>
                </div>

                <div class="sub3 sub">
                    <div class="sub3-1">
                        <div class="form-grp">
                            <label>City/Vilage</label>
                            <input type="text" name="city" class="form-control" placeholder="City/Village" required>
                        </div>

                        <div class="form-grp">
                            <label>Pincode</label>
                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                class="form-control" name="pincode" placeholder="Pincode" maxlength="6" required>
                        </div>

                        <div class="form-grp">
                            <label>Contact Number</label>
                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                class="form-control" name="contact" placeholder="Contact Number" maxlength="10" required>
                        </div>

                        <div class="form-grp">
                            <label>University Email ID</label>
                            <input type="email" name="email" class="form-control" placeholder="University Email ID" required>
                        </div>

                    </div>
                    <div class="sub3-2">

                        <div class="form-grp">
                            <label>Date of birth</label>
                            <input type="date" name="dob" class="form-control" placeholder="date" required>
                        </div>

                        <div class="form-grp">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="ename" class="form-control" placeholder="Emergency Name" required>
                        </div>

                        <div class="form-grp">
                            <label>Emergency Contact Relation</label>
                            <select class="form-control" name="erelation" required>
                                <option selected style="display:none;" value="0">Emergency Relation</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Friend">Friend</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-grp">
                            <label>Emergency Contact Number</label>
                            <input type="number" name="econtact" oninput="javascript: if (this.value.length > this.maxLength) this.value = 
                                this.value.slice(0, this.maxLength);" class="form-control" maxlength="10" placeholder="Emergency Number" required>
                        </div>
                    </div>
                </div>
                
                <div class="sub5 sub">
                    <div class="sub5-1">
                        <div class="form-grp">
                            <label>Enter Password</label>
                            <input type="password" name="password1" id="password1" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="sub5-2">
                        <div class="form-grp">
                            <label>Confirm password</label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm password" required>
                        </div>
                    </div>
                </div>

                <div class="sub5 sub">
                    <div class="sub5-1">
                        <div class="form-grp">
                            <label>Upload Passport Photo</label><br>
                            <input type="file" name="passport" id="passport" accept="image/*" required>
                            <div id="prepass"><img id="passpreview" alt="Passport Image"></div>
                        </div>
                    </div>
                    <div class="sub5-2">
                        <div class="form-grp">
                            <label>Upload ID Card </label><br>
                            <input type="file" name="idcard" id="idcard" accept="image/*" required>
                            <div id="preid"><img id="idcardpreview" alt="ID Card"></div>
                        </div>
                    </div>
                </div>

                <script>
                    //For passport size image
                    const inputimgpass = document.getElementById('passport');
                    const previewpass = document.getElementById('passpreview');

                    function hideshowpass() {
                        if (inputimgpass.files.length == 0) {
                            document.getElementById('prepass').style.display = "none";
                        } else {
                            document.getElementById('prepass').style.display = "block";
                            const file = inputimgpass.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = function(e) {
                                    previewpass.src = e.target.result;
                                }
                            }
                        }
                    }
                    inputimgpass.addEventListener('change', hideshowpass);

                    //For ID Card image
                    const inputimgidcard = document.getElementById('idcard');
                    const previewidcard = document.getElementById('idcardpreview');

                    function hideshowid() {
                        if (inputimgidcard.files.length == 0) {
                            document.getElementById('preid').style.display = "none";
                        } else {
                            document.getElementById('preid').style.display = "block";
                            const file = inputimgidcard.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = function(e) {
                                    previewidcard.src = e.target.result;
                                }
                            }
                        }
                    }
                    inputimgidcard.addEventListener('change', hideshowid);
                </script>

                <div class="checkboxes">
                    <div class="sub-check"><input type="checkbox" onclick="myFunction2()"><span>Show Password</span></div>
                    <div class="sub-check"><input type="checkbox" required><span>I agree to all the <a href="terms&conditions" target="_blank">terms and conditions.</a></span></div>
                </div>
                <script>
                    function myFunction2() {
                        var p1 = document.getElementById("password1");
                        var p2 = document.getElementById("password2");
                        if (p1.type === "password") {
                            p1.type = "text";
                            p2.type = "text";
                        } else {
                            p1.type = "password";
                            p2.type = "password";
                        }
                    }
                </script>
                <div class="submit-cont"><button type="submit" class="submit-btn">Register</button></div>
            </form>
        </div>
    </div>
    <script>
        var form_box = document.getElementById("form-box");
        var logn_btn = document.getElementById("login-btn");
        var rgtr_btn = document.getElementById("register-btn");
        var logn_div = document.getElementById("login-container");
        var rgtr_div = document.getElementById("register-container");

        function register() {
            form_box.style.width = "85%";
            logn_div.classList.add("hidden");
            rgtr_div.classList.remove("hidden");
            logn_btn.classList.remove("active-btn");
            rgtr_btn.classList.add("active-btn");
        }

        function login() {
            form_box.style.width = "30vw";
            logn_div.classList.remove("hidden");
            rgtr_div.classList.add("hidden");
            logn_btn.classList.add("active-btn");
            rgtr_btn.classList.remove("active-btn");
        }

        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="inspect.js"></script>
</body>
</html>