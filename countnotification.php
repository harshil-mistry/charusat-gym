<?php
session_start();
include("config.php");
if (!isset($_SESSION['id']) || $_SESSION['type']=='admin') {
    $subscribed = false;
    $gender = "Male";
} else {
    $id = $_SESSION['id'];
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
    $row = mysqli_fetch_assoc($result);
    $gender = $row['gender'];
}
if ($subscribed || $gender=="Female") {
    $sql = "SELECT * FROM notifications ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM notifications WHERE `target`='all' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
}
$notificationCount = mysqli_num_rows($result);
?>