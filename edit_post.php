<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Dohvati podatke o postu iz baze
    $stmt = $mysqli->prepare("SELECT user_name, title, text FROM post WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->bind_result($user_name, $title, $text);
    $stmt->fetch();
    $stmt->close();

    // Provjeri je li trenutni korisnik vlasnik posta
    if ($_SESSION['user_name'] != $user_name) {
        // Ako nije vlasnik, možete preusmjeriti korisnika ili prikazati poruku o greški
        echo "You don't have permission to edit this post.";
        exit;
    }
} else {
    // Ako ID posta nije dostupan, možete preusmjeriti korisnika ili prikazati poruku o greški
    echo "Post ID not provided.";
    exit;
}

// Post metoda - ažuriraj post u bazi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Provjeri je li korisnik poslao traženi post
    if (isset($_POST['update_post'])) {
        $new_title = $_POST['new_title'];
        $new_text = $_POST['new_text'];

        // Ažuriraj post u bazi
        $stmt = $mysqli->prepare("UPDATE post SET title = ?, text = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_title, $new_text, $post_id);
        $stmt->execute();
        $stmt->close();

        // Uspješno ažuriranje - možete preusmjeriti korisnika ili prikazati poruku o uspjehu
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style_login.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Edit post</title>

    <!-- CSS only -->


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>
<body>
<div class="mt-4 p-5 text-black header">
    <h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
             class="bi bi-postcard-heart" viewBox="0 0 16 16">
            <path fill="rgb(224, 92, 123)"
                  d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622M2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
            <path fill="currentColor" fill-rule="evenodd"
                  d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z" />
        </svg>
        </svg>
        Postify
    </h1>
</div>

<nav class="navbar navbar-expand-lg" style="background-color: rgb(126, 188, 230);">>
    <div class="container-fluid">
        <a class="navbar-brand" href="#" style="color: white">Postify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php" style="color: white">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php" style="color: white">User</a>
                </li>
                <li class="nav-item dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" id="myInput" type="search" placeholder="Search"
                       aria-label="Search" />
                <button class="btn btn-light" type="submit"
                        style="color: white; background-color: rgb(126, 188, 230);">Search</button>


                <button class="btn btn-light" href="logout.php"><a href="logout.php"
                                                                   style="color: rgb(15, 26, 94);">Logout</a></button>


            </form>
        </div>
    </div>
</nav>


<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Edit Post</h1>

        <form method="post" action="">
            <div class="mb-3">
                <label for="new_title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="new_title" name="new_title"
                       value="<?php echo $title; ?>" required>
            </div>

            <div class="mb-3">
                <label for="new_text" class="form-label">Text:</label>
                <textarea class="form-control" id="new_text" name="new_text" rows="4"
                          required><?php echo $text; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="update_post">Update Post</button>
        </form>
    </div>
</div>

</body>

</html>