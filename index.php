<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Dohvaćanje podataka o korisniku iz baze podataka
$stmt = $mysqli->prepare("SELECT profile_image FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($profile_image);
$stmt->fetch();
$stmt->close();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style_login.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>

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
                        <a class="nav-link active" aria-current="page" href="#" style="color: white">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php" style="color: white">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php" style="color: white" <?php if (!$_SESSION['is_admin']) {
                            echo "hidden";
                        } ?>>Users</a>
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





    <br>

    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 gedf-main">
                <!--- \\\\\\\Post-->
                <div class="card gedf-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab"
                                    aria-controls="posts" aria-selected="true">Make a publication</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel"
                                aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <form method="post" action="insert.php">
                                        <textarea class="form-control" id="title" rows="1" placeholder="Title"
                                            name="title1" required></textarea>
                                        <textarea class="form-control" id="post-textarea" rows="3"
                                            placeholder="What are you thinking?" name="post1" required></textarea>

                                </div>
                            </div>
                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-dark" id="post-btn"
                                        style="background-color: rgb(15, 26, 94);">Post</button>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-light" onclick="getQuote()"
                                        style="background-color: rgb(224, 92, 123); color: white;">Get Quote</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="quote">
                                <p id="quoteText"></p>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $mysqli = require __DIR__ . "/database.php";
                function get_user($name = NULL)
                {
                    global $mysqli;

                    if ($name != NULL) {
                        $query = "SELECT * FROM user WHERE name=?";
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param("s", $name);
                        $stmt->execute();

                        if ($stmt->error) {
                            return "Error executing query: " . $stmt->error;
                        }

                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            return $result->fetch_assoc();
                        } else {
                            return "User not found.";
                        }
                    }
                }



                if ($mysqli === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                $sql = "SELECT id, user_name, title, text, created_time FROM post  ORDER BY id DESC";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $user = get_user($row['user_name']);

                        ?>

                        <div class="card gedf-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">




                                                <img src="<?php echo $user['profile_image'] ?>" alt="Profile Picture"
                                                    class="rounded-circle" width="50" height="50" />

                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">@
                                                <?php echo $row["user_name"]; ?>
                                            </div>
                                            <div class="h7 text-muted">
                                                <?php echo $row["user_name"]; ?>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-muted h7 mb-2">
                                    <?php

                                    $timestamp = strtotime($row["created_time"]);
                                    $datetime = new DateTime();
                                    $datetime->setTimestamp($timestamp);
                                    echo $datetime->format('F j, Y, g:i a');
                                    ?>
                                    </i>
                                </div>
                                <a class="card-link" href="post_details.php?id=<?php echo $row['id']; ?>">
                                    <h5 class="card-title">
                                        <?php echo $row["title"]; ?>
                                    </h5>
                                </a>


<!--                                <p class="card-text">-->
<!--                                    --><?php //echo $row["text"]; ?>
<!---->
<!---->
<!--                                </p>-->
                            </div>
                            <div class="card-footer">




                                <form action="delete.php" method="post" style="d-flex justify-content-between">
                                    <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                                    <button type="submit" name="delete" class="card-link"
                                        style="border: none; background: none;" <?php if ($_SESSION['user_name'] != $row["user_name"] && $_SESSION["is_admin"] == 0) {
                                            echo "hidden";
                                        } ?>>
                                        <i class="fa fa-trash-o" aria-hidden="true" style="font-size: 20px;"></i>
                                    </button>


                                    <?php if ($_SESSION['user_name'] === $row["user_name"]) { ?>
                                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="card-link">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                </form>



                            </div>

                        </div>

                        <?php
                    }
                }

                $mysqli->close();


                ?>

                <!--do tud ide post-->


            </div>
            <script>
                function getQuote() {
                    fetch('https://api.quotable.io/random')
                        .then(response => response.json())
                        .then(data => {
                            // const quoteElement = document.getElementById('quoteText');
                            // quoteElement.textContent = `"${data.content}" - ${data.author}`;

                            document.getElementById('post-textarea').value = `"${data.content}" - ${data.author}`;

                        })
                        .catch(error => console.error('Error fetching quote:', error));
                }

            </script>



        </div>


        <!-- tu->

            