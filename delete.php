<?php
$mysqli = require __DIR__ . "/database.php";

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM post WHERE id='$id'";
    $query_run = mysqli_query($mysqli, $query);

    if ($query_run) {
        // Ako je brisanje posta uspješno, sada možete obrisati i povezane komentare
        $deleteCommentsQuery = "DELETE FROM comments WHERE post_id = '$id'";
        $deleteCommentsResult = mysqli_query($mysqli, $deleteCommentsQuery);

        if ($deleteCommentsResult) {
            // Komentari su uspješno obrisani
            header("Location: index.php");
            exit; // Odmah izlazimo iz skripte nakon preusmjeravanja
        } else {
            // Greška pri brisanju komentara
            echo "Error deleting comments: " . mysqli_error($mysqli);
        }
    } else {
        // Greška pri brisanju posta
        echo "Error deleting post: " . mysqli_error($mysqli);
    }
}
?>