<?php

session_start();
$mysqli = require __DIR__ . "/database.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


// Dohvaćanje podataka o korisniku iz baze podataka
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT name, email, profile_image FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $email, $profile_image);
$stmt->fetch();
$stmt->close();

$target_file = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $target_dir = "uploads/";

    $target_file = $target_dir . $user_id . "." . pathinfo(basename($_FILES["profile_image_file"]["name"]), PATHINFO_EXTENSION);;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $error = "";

    $check = getimagesize($_FILES["profile_image_file"]["tmp_name"]);

    if ($check !== false) {
        $uploadOk = 1;
        //echo $uploadOk."?";

    } else {
        $error = "File is not an image.";
        echo $uploadOk."*";

    }


    if ($_FILES["profile_image_file"]["size"] > 5000000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
        echo $uploadOk."+";
    }


    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        echo $uploadOk."=";
    }


    if ($uploadOk == 0) {
        set_message('Error uploading file: ' . $error);
    } else {

//        $sql = "UPDATE user SET profile_image='$target_file' WHERE id=$user_id";
//        confirm(query($sql));
        $sql = "UPDATE user SET profile_image=? WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $target_file, $user_id);
        $result = $stmt->execute();





        if (!move_uploaded_file($_FILES["profile_image_file"]["tmp_name"], $target_file)) {
            echo "test";
            set_message('Error uploading file: ' . $error);
        }
    }


    header("Location: profile.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .navbar {
            overflow: hidden;
            background-color: rgb(126, 188, 230);
            /* Plava boja za traku */
            width: auto;
            /* Širina trake */
            border-radius: 8px;
            /* Zaobljeni rubovi */
            position: fixed;
            /* Fiksni položaj */
            top: 30px;
            /* Postavljanje trake malo ispod vrha */
            z-index: 1000;
            /* Visoki z-index za postavljanje iznad ostalog sadržaja */
            display: flex;
            justify-content: center;
            /* Centriranje horizontalno */
        }

        .navbar ul {
            list-style-type: none;
            /* Uklanjanje točkica */
            margin: 0;
            padding: 0;
        }

        .navbar a {
            display: block;
            color: white;
            text-align: center;
            padding: 10px 8px;
            /* Prilagođena širina trake */
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            /* Tranzicija boje pozadine */
        }

        .navbar a:hover {
            background-color: #29526d;
            /* Boja na hover */
        }

        .navbar #home-link {
            padding-left: 0;
            /* Uklonjen padding za "Home" */
            display: flex;
            align-items: center;
            /* Centriranje ikonice i teksta */
        }

        .navbar #home-link i {
            margin-right: 5px;
            /* Razmak između ikonice i teksta "Home" */
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }

        .profile-info {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(126, 188, 230);
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin: 20px;
        }

        .user-details {
            text-align: left;
            padding-left: 20px;
        }

        .profile-picture {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 20px;
        }

        .profile-picture img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .upload-button {
            background-color: #3366ff;
            /* Originalna plava boja */
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .icon i {
            font-size: 32px;
            /* Povećana veličina ikonice */
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php" id="home-link"><i class="fas fa-home"></i> Home</a></li>
        </ul>
    </nav>
    <div class="profile-info">
        <!-- Prikaz slike profila -->
        <div class="profile-info">
            <!-- Prikaz slike profila -->
            <div class="profile-picture">
                <img class="rounded-circle" width="150" height="150" src="<?php echo $profile_image; ?>"
                    alt="Profile Picture" id="profile-pic" />
            </div>
            <!-- Gumb za promjenu slike profila -->
            <div class="dropdown">
<!--                <button class="upload-button">Change your profile picture</button>-->
<!--                <div class="dropdown-content">-->
<!--                    <form method="post" enctype="multipart/form-data">-->
<!--                        <input type="file" name="image" class="hidden-file-input hidden"-->
<!--                            onchange="updateProfilePicture()">-->
<!--                    </form>-->
                    <form method="POST" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="profile_image_file">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
<!--                </div>-->
            </div>
        </div>
        <div class="profile-info">
            <div class="user-details">
                <div class="icon">
                    <i class="fas fa-address-card"></i>
                </div>
                <p>Name:
                    <?php echo $name; ?>
                </p>
                <p>Email:
                    <?php echo $email; ?>
                </p>
            </div>
        </div>

</body>

</html>

<script>
    function updateProfilePicture() {
        const fileInput = document.querySelector('.hidden-file-input');
        const image = fileInput.files[0];

        const formData = new FormData();
        formData.append('image', image);

        fetch('update_profile.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                return response.text();
            })
            .then(data => {
                // Ovdje ažuriramo prikaz profila nakon što se slika uploada
                document.getElementById('profile-pic').src = URL.createObjectURL(image);
                console.log(data);
            })
            .catch(error => {
                // Uhvatiti i obraditi greške
                console.error('There has been a problem with your fetch operation:', error);
            });
    }
</script>