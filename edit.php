<?php
require_once 'includes/db.php';

//Grabbing the ID of the chosen reservation with GET

$index = $_GET['id'];

//Use the select query to look for the reservation in the database with the same id
$query = "SELECT * FROM reserveringen WHERE id =  $index";

//Preform the query
/** @var $db */
$result = mysqli_query($db, $query)
or die ('Error: ' . mysqli_error($db));

// Put the table that has been retrieved in a variable to be able to use it.

$selectedReservation = mysqli_fetch_assoc($result);


//The input date uses data from the table availability
$query = "SELECT * FROM availability" ;

//Preform the query
$result = mysqli_query($db, $query) or die ('Error: ' . $query);

//make an array where all the data from the table will be stored in
$dates = [];

//loop through all the data
while($row = mysqli_fetch_assoc($result))
{

    $dates[] = $row;
}

//only if submit is clicked will something happen
if (isset($_POST['submit'])){

//receive the date
    $name = $_POST['name'];
    $rate = $_POST['quantity'];
    $shift = $_POST['shift'];
    $details = $_POST['details'];
    $date = $_POST['date'];

    //adding validation, so we are sure every input has been filled before something happens
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



    //only if there are no errors will the query actually work
    if (empty($errors)) {
        //INSERT in DB
        $query = "UPDATE `reserveringen` SET name= '$name', rate= '$rate', shift='$shift', details='$details', date='$date' 
                  WHERE id = $index;";
        $resultaat = mysqli_query($db, $query)
        or die('Error: '.mysqli_error($db).' with query: '.$query);

        if ($resultaat) {
           header("location: beschikbaarheid.php");
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }

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
    <title>Document</title>
</head>
<body>
<section>
    <h1><?= $selectedReservation['name'] ?>
        <?= $selectedReservation['rate'] ?>
        <?= $selectedReservation['shift'] ?>
        <?= $selectedReservation['details'] ?>
        <?= $selectedReservation['date'] ?>
    </h1>
</section>

    <form action="" method="post">

            <label for="username">Naam instelling</label>
            <input id="username" type="text" name="name" placeholder="Naam" />
            <span><?= $errors['name'] ?? ''  ?></span>


            <label for="quantity">Uur tarief €</label>
            <input type="number" id="quantity" name="quantity" min="15" >
            <span><?= $errors['quantity'] ?? ''  ?></span>


            <label for="shift">Dienst</label>
            <select name="shift" id="shift">
                <option value="">Selecteer shift</option>
                <option value="avond">Avond</option>
                <option value="ochtend">Ochtend</option>
            </select>
            <span><?= $errors['shift'] ?? ''  ?></span>



            <label for="details">Details</label>
            <textarea name="details" id="details" placeholder="Details van de shift"></textarea>
            <span><?= $errors['details'] ?? ''  ?></span>


            <label for="date">Datum</label>
            <select name="date" id="date">
                <option value="">Kies een datum</option>
                <?php foreach ($dates as  $date) {?>
                    <option value="<?= $date['datum']?>"><?= $date['datum'] ?></option>
                <?php } ?>
            </select>
            <span><?= $errors['date'] ?? ''  ?></span>

        <button type="submit" name="submit" class="submit">Maak afspraak</button>

    </form>
</body>
</html>


