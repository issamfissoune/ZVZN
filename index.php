<?php
session_start();
//$host = "localhost";
//$user = "root";
//$password = "";
//$database = "ZVZN";
//
//$db = mysqli_connect($host, $user, $password, $database)
//or die("Error:" . mysqli_connect_error());

require_once "includes/db.php";

$query = "SELECT * FROM reserveringen";

/** @var $db */

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);


$reserveringen = [];

while($row = mysqli_fetch_assoc($result))
{

    $reserveringen[] = $row;
}

mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./stylesheets/portfolio.css">
    <title>Portfolio</title>
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



<section>
<div class="Scroll-container">
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Noura Gourari</h2>
        <p>Ik ben Noura, de oprichter van ZVDZN, op deze website kan je mij inhuren om voor je instelling te werken.</p>
        <a href="booking.php" class="button">Maak afspraak</a>
        <a href="#" class="button">Meer over mij</a>
    </div>
</div>
</div>
</section>
<footer>
    Contacts:
</footer>

</body>
</html>