<?php
session_start();

require_once 'includes/db.php';

if (isset($_POST['submit'])) {

    $date = $_POST['date'];


    $errors = [];
    if ($date == "") {
        $errors['date'] = "Vul aub uw beschikbare datum in";

        header('location:beschikbaarheid.php');
    }


    if (empty($errors)) {
        //INSERT in DB
        $query = "INSERT INTO availability (datum)
                    VALUES('$date')";
        $result = mysqli_query($db, $query)
        or die('Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            $success = "Hij is toegevoegd aan de DB";
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }
}

$query = "SELECT * FROM availability";

/** @var $db */

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);


$availability = [];

while($row = mysqli_fetch_assoc($result))
{

    $availability[] = $row;
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

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>beschikbaarheid</th>
        <th>Kies datum</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="6">&copy; Reserveringen</td>

    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($availability as  $available) {?>
        <tr>
            <td><?= $available['id']?></td>
            <td><?= $available['datum'] ?></td>
            <td><a href="booking.php?id=<?=$available['id'] ?>">Kies een datum</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<form action="" method="post">

    <label for="date">Beschikbaarheid</label>
    <input type="date" name="date" min="<?= date('Y-m-d')?>">
    <span><?= $errors['date'] ?? ''  ?></span>
    <input type="submit" name="submit" value="Toevoegen">
</form>

</body>
</html>
