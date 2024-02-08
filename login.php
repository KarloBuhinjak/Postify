<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user
            WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["is_admin"] = $user["is_admin"];
            header("Location: index.php");
            exit;
        }
    }
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style_login.css" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                class="bi bi-postcard-heart" viewBox="0 0 16 16">
                <path fill="rgb(224, 92, 123)"
                    d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622M2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
                <path fill="currentColor" fill-rule="evenodd"
                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z" />
            </svg>
            </svg>
        </div>
        <div class="text-center mt-4 name">Postify</div>



        <form class="p-3 mt-3" method="post">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="email" name="email" id="email" placeholder="E-mail adress"
                    value="<?= htmlspecialchars(isset($_POST["email"]) ? $_POST["email"] : "") ?>">


            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password" />
            </div>
            <button class="btn mt-3">Login</button>
        </form>
        <?php if ($is_invalid): ?>
            <em>Invalid login</em>
        <?php endif; ?>
        <div class="text-center fs-6">
            <a href="register.html" style="font-size: 14px;">Sign up</a>
        </div>
    </div>
</body>

</html>