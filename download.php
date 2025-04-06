<?php

include('config.php');
session_start();
$id = $_GET['id'];
if (!isset($_SESSION['id']) or $_SESSION['id'] != $id) {
    $_SESSION['newalert'] = "Invalid access of page";
    header('Location: /');
}

$sql = "SELECT gender FROM profiles WHERE `studentid` = '$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $gender = mysqli_fetch_array($result)[0];
    if ($gender == 'Male') {
        $result = mysqli_query($conn, "SELECT card FROM subscriptions WHERE `studentid` = '$id'");
    } else {
        $result = mysqli_query($conn, "SELECT card FROM female WHERE `studentid` = '$id'");
    }

    if (mysqli_num_rows($result)) {
        $image = mysqli_fetch_array($result)[0];
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . $id . '_profile.png"');
        echo $image;
    } else {
        echo "No card found for id $id";
    }
} else {
    echo "No user found of id $id";
}

?>