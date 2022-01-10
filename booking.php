<?php
//$host = "localhost";
//$user = "root";
//$password = "";
//$database = "ZVZN";
//
//$db = mysqli_connect($host, $user, $password, $database)
//or die("Error:" . mysqli_connect_error());

require_once 'includes/db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $rate = $_POST['quantity'];
    $shift = $_POST['shift'];
    $details = $_POST['details'];
    $date = $_POST['date'];


    $errors = [];
    if ($name == "") {
        $errors['name'] = "Vul aub uw voornaam in";
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
    }  elseif (isset($_GET['id']) || $_GET['id'] != ''){
        $beschikbaarheid = $_GET['id'];

        $query = "SELECT * FROM availability WHERE id =  '$beschikbaarheid'";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query);

        if (mysqli_num_rows($result) == 1) {
            $beschikbaarheid = mysqli_fetch_assoc($result);
        } else {
            // redirect when db returns no result
            header('Location: index.php');
            exit;
        }

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
    <link rel="stylesheet" href="stylesheets/booking.css">
    <title>Booking</title>

</head>
<body>

<?php
if (isset($errors['db'])) {
    echo $errors['db'];
} elseif (isset($success)) {
    echo $success;
}
?>
<div class="container">
    <form action="" method="post">
            <div class="data-field">
                <label for="username">Naam instelling</label>
                <input id="username" type="text" name="name" placeholder="Naam" />
            </div>
        <?php
        if (isset($errors['name'])) {
            echo $errors['name'];
        }
        ?>

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
        <?php
        if (isset($errors['shift'])) {
            echo $errors['shift'];
        }
        ?>
        <div class="data-field ">
            <label for="details">Details</label>
            <textarea name="details" id="details" placeholder="Details van de shift"></textarea>
        </div>
        <?php
        if (isset($errors['details'])) {
            echo $errors['details'];
        }
        ?>
        <div class="data-field ">
            <label for="date">Datum</label>
            <input type="date" name="date" value="<?= $beschikbaarheid['date'] ?>"/>

        </div>

        <div class="data-field space">
            <input type="submit" name="submit" placeholder="submit" value="submit"/>
        </div>




    </form>


</div>
<a href="index.php">Back to the home screen</a>
</body>
</html>
