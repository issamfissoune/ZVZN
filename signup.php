<?php
session_start();

$name = '';
$password = '';

//If our session doesn't exist, redirect & exit script
if (isset($_SESSION['loggedInUser'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    //Require database in this file & image helpers
    /** @var mysqli $db */
    require_once "includes/db.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name = mysqli_escape_string($db, $_POST['name']);
    $password = $_POST['password'];

    $errors = [];
    if ($name == '') {
        $errors['name'] = 'naam instelling moet ingevuld worden';
    }
    if ($password == '') {
        $errors['password'] = 'Wachtwoord mag niet leeg blijven';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, password, type) VALUES('$name', '$password','user')";

        $result = mysqli_query($db, $query) or die('Error: ' . $query);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>signup</title>
    <link rel="stylesheet" href="./stylesheets/signup.css">
</head>
<body>
<nav>

    <h1 class="effect">
        <span>Z</span><span>org</span>
        <span>V</span><span>oor</span>
        <span>D</span><span>e</span>
        <span>Z</span><span>org</span>
        <span>N</span><span>oura</span>

    </h1>
    <!--    <h1>Zorg Voor De Zorg Noura</h1>-->
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
    </ul>
</nav>

<div class="form">
    <form action="" method="post">
    <div class="title">Welcome</div>
    <div class="subtitle">Create your account</div>
    <div class="input-container ic1">
        <input id="name" class="input" type="text" name="name" placeholder=" " value="<?= htmlentities($name); ?>"/>
        <div class="cut"></div>
        <label for="name" class="placeholder">Naam Instelling</label>
        <span class="errors"><?= $errors['name'] ?? ''; ?></span>
    </div>
        <div class="input-container ic2">
            <input id="password" class="input" name="password" type="password" placeholder=" " />
            <div class="cut cut-short"></div>
            <label for="password" class="placeholder">Password</label>
            <span class="errors"><?= $errors['password'] ?? ''; ?></span>
            <input type="checkbox" onclick="myFunction()">Show Password
        </div>
    <button type="submit" name="submit" class="submit">submit</button>
    </form>
</div>
<script src="showPW.js"></script>
</body>
</html>
