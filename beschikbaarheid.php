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
    <link rel="stylesheet" href="stylesheets/beschikbaarheid.css">
    <title>Beschikbaarheid</title>

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


<div class="container">
    <div class="container-table">
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Beschikbaarheid</th>


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

        </tr>
    <?php } ?>
    </tbody>
</table>




<form action="" method="post">

    <label for="date">Beschikbaarheid</label>
    <input type="date" name="date" min="<?= date('Y-m-d')?>">
    <span><?= $errors['date'] ?? ''  ?></span>
    <div class="data-submit">
    <input type="submit" name="submit" value="Toevoegen">
    </div>

    <div>
        <a class="ignore" href="index.php">Terug naar start pagina</a>
    </div>

</form>
</div>


<div class="container-form">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>rate</th>
                <th>shift</th>
                <th>details</th>
                <th>Weigeren</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="6">&copy; Reserveringen</td>

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
</div>

</div>
</body>
</html>
