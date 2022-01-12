<?php

session_start();
//$host = "localhost";
//$user = "root";
//$password = "";
//$database = "ZVZN";
//
//$db = mysqli_connect($host, $user, $password, $database)
//or die("Error:" . mysqli_connect_error());

require_once 'includes/db.php';
/** @var mysqli $db */
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $rate = $_POST['quantity'];
    $shift = $_POST['shift'];
    $details = $_POST['details'];
    $date = $_POST['date'];


    $errors = [];
    if ($name == "") {
        $errors['name'] = "Vul aub de naam van de instelling in";
    }
    if ($rate == "") {
        $errors['quantity'] = "Vul aub het tarief in";
    }
    if ($shift == "") {
        $errors['shift'] = "Vul aub de shift in";
    }
    if ($details == "") {
        $errors['details'] = "Vul aub de details in";
    }
    if ($date == "") {
        $errors['date'] = "Kies aub een datum";
    }

//
    if (empty($errors)) {
        //INSERT in DB
        $query = "INSERT INTO reserveringen (name , rate, shift, details, date)
                    VALUES('$name', '$rate','$shift','$details','$date')";
        $result = mysqli_query($db, $query)
            or die('Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            $success = "Hij is toegevoegd aan de DB";
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }


    $query = "DELETE FROM availability WHERE datum = '$date'";

    mysqli_query($db, $query);


}

$query = "SELECT * FROM availability" ;
$result = mysqli_query($db, $query) or die ('Error: ' . $query);

$dates = [];

while($row = mysqli_fetch_assoc($result))
{

    $dates[] = $row;
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
    <link rel="stylesheet" href="stylesheets/booking.css">
    <title>Booking</title>

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

    <div class="container-input">
    <form action="" method="post">
            <div class="data-field">
                <label for="username">Naam instelling</label>
                <input id="username" type="text" name="name" placeholder="Naam" />
            </div>
        <span><?= $errors['name'] ?? ''  ?></span>

            <div class="data-field ">
                <label for="quantity">Uur tarief €</label>
                <input type="number" id="quantity" name="quantity" min="15" >
            </div>
            <span><?= $errors['quantity'] ?? ''  ?></span>

            <div class="data-field ">
                <label for="shift">Dienst</label>
                <select name="shift" id="shift">
                    <option value="">Selecteer shift</option>
                    <option value="avond">Avond</option>
                    <option value="ochtend">Ochtend</option>
                </select>
            </div>
        <span><?= $errors['shift'] ?? ''  ?></span>


        <div class="data-field ">
            <label for="details">Details</label>
            <textarea name="details" id="details" placeholder="Details van de shift"></textarea>
        </div>
        <span><?= $errors['details'] ?? ''  ?></span>

        <div class="data-field ">
            <label for="date">Datum</label>
            <select name="date" id="date">
                <option value="">Kies een datum</option>
                <?php foreach ($dates as  $date) {?>
                <option value="<?= $date['datum']?>"><?= $date['datum'] ?></option>
                <?php } ?>
            </select>
        </div>
        <span><?= $errors['date'] ?? ''  ?></span>

        <button type="submit" name="submit" class="submit">Maak afspraak</button>




    </form>
        <a href="index.php" class="button">Back to the home screen</a>
    </div>



</body>
</html>
