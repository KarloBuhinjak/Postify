<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$title1 = $_POST['title1'];
$post1 = $_POST['post1'];
$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];

$mysqli = require __DIR__ . "/database.php";

// Check connection
if ($mysqli === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt insert query execution
$sql = "INSERT INTO post (user_id,user_name,title, text) VALUES ('$user_id','$user_name', '$title1', '$post1')";
if (mysqli_query($mysqli, $sql)) {
    echo "Records inserted successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
}

// Close connection
mysqli_close($mysqli);
header("Location: index.php");
exit();