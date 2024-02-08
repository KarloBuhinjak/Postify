<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $user_id = $_SESSION['user_id'];

    // Dobivanje putanje datoteke i njenog tipa
    $file_name = $_FILES["image"]["name"];
    $temp_name = $_FILES["image"]["tmp_name"];
    $file_type = $_FILES["image"]["type"];

    // Provjera da li je odabrana slika
    if ($file_type == "image/jpeg" || $file_type == "image/png") {
        // Spremanje slike na server
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);

        if (move_uploaded_file($temp_name, $target_file)) {
            // Ažuriranje putanje nove slike u bazi podataka
            $stmt = $mysqli->prepare("UPDATE user SET profile_image = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            $stmt->close();

            // Preusmjeravanje na profilnu stranicu nakon ažuriranja slike
            header("Location: profile.php");
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Only JPG and PNG files are allowed.";
    }
}

if (move_uploaded_file($temp_name, $target_file)) {
    // Ažuriranje putanje nove slike u bazi podataka
    $stmt = $mysqli->prepare("UPDATE user SET profile_image = ? WHERE id = ?");
    $stmt->bind_param("si", $target_file, $user_id);
    $stmt->execute();
    $stmt->close();

    // Preusmjeravanje na profilnu stranicu nakon ažuriranja slike
    header("Location: profile.php");
    exit;
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>