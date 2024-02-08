<?php



if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-zA-Z]/", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash, profile_image)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Koristite varijable za bind_param
$name = $_POST["name"];
$email = $_POST["email"];
$profile_image = "uploads/default.jpg";

$stmt->bind_param("ssss", $name, $email, $password_hash, $profile_image);

if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    die($stmt->error . " " . $stmt->errno);
}