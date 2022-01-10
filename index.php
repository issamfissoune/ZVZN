<?php

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


<aside>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>name</th>
        <th>rate</th>
        <th>shift</th>
        <th>details</th>
        <th>Wijgeren</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="6">&copy; Reserveringen</td>
        <td><a href="beschikbaarheid.php">Nieuwe datums toevoegen</a></td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($reserveringen as  $reservering) {?>
        <tr>
            <td><?= $reservering['id'] ?></td>
            <td><?= $reservering['name'] ?></td>
            <td><?= $reservering['rate'] ?></td>
            <td><?= $reservering['shift'] ?></td>
            <td><?= $reservering['details'] ?></td>
            <td><a href="reject.php?id=<?= $reservering['id'] ?>">Weigeren</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
    </aside>

</section>

<footer>
    Contacts:
</footer>
</body>
</html>