<?php
require_once 'includes/db.php';
//require_once 'index.php';
session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}

$index = $_GET['id'];

$query = "SELECT * FROM reserveringen WHERE id =  $index";

/** @var $db */
$result = mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

$selectedBooking = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){

    $query = "DELETE FROM reserveringen WHERE id =" . $_POST['id'];

    mysqli_query($db, $query);

    header('Location: index.php');
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete</title>
</head>
<body>
<section>
    <h1><?= $selectedBooking['name'] ?></h1>
    <ul>
        <li>Shift: <?= $selectedBooking['shift'] ?></li>
        <li>Details: <?= $selectedBooking['details'] ?></li>

    </ul>
</section>

<form action="" method="post">
    <p>
       weiger "<?= $selectedBooking['name'] ?>" uit tabel?
    </p>
    <input type="hidden" name="id" value="<?= $selectedBooking['id'] ?>"/>
    <input type="submit" name="submit" value="weigeren"/>
</form>
</body>
</html>
