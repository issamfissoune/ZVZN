<?php
session_start();
//Require database in this file
/** @var mysqli $db */
require_once "includes/db.php";

//Check if user is logged in, else move to secure page
if (isset($_SESSION['loggedInUser'])) {
    header("Location: index.php");
    exit;
}

//If form is posted, lets validate!
if (isset($_POST['submit'])) {
    //Retrieve values (email safe for query)
    $name = mysqli_escape_string($db, $_POST['name']);
    $password = $_POST['password'];

    //Get password & name from DB
    $query = "SELECT * FROM users
              WHERE name = '$name'";
    $result = mysqli_query($db, $query) or die('Error: '.$query);
    $user = mysqli_fetch_assoc($result);

    //Check if email exists in database
    $errors = [];


    if ($user) {
        //Validate password
        if (password_verify($password, $user['password'])) {
            //Set email for later use in Session
            $_SESSION['loggedInUser'] = [
                'name' => $user['name'],
                'id' => $user['id'],
                'type' => $user['type'],
            ];

            //Redirect to secure.php & exit script
            header("Location: index.php");
            exit;
        } else {
            $errors[] = 'Uw logingegevens zijn onjuist';
        }
    } else {
        $errors[] = 'Uw logingegevens zijn onjuist';
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
    <title>Login</title>
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
        <?php    if (isset($_SESSION['loggedInUser']) && $_SESSION['loggedInUser']['type'] == 'admin' ): ?>
            <li><a href="beschikbaarheid.php">Beschikbaarheid</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['loggedInUser'])) : ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>

    </ul>
</nav>

<?php if (isset($errors) && !empty($errors)) { ?>
    <ul class="errors">
        <?php for ($i = 0; $i < count($errors); $i++) { ?>
            <li><?= $errors[$i]; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<div class="form">
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" >
    <div class="title">Welcome</div>
    <div class="subtitle">Fill in your details to login!</div>
        <div class="input-container ic1">
            <input id="name" class="input" type="text" name="name" placeholder=" " value="<?= htmlentities($name); ?>"/>
            <div class="cut"></div>
            <label for="name" class="placeholder">Naam Instelling</label>
        </div>
    <div class="input-container ic2">
        <input id="password" name="password" class="input" type="password" placeholder=" " />
        <div class="cut"></div>
        <label for="password" class="placeholder">Password</label>
        <input type="checkbox" onclick="myFunction()">Show Password
    </div>

    <button type="submit" name="submit" class="submit">Login</button>
    <p class="mb-0 mt-4 text-center"><a href="signup.php" class="link">Nog geen account? Sign Up hier</a></p>
    </form>
</div>

<script src="showPW.js"></script>
</body>
</html>

