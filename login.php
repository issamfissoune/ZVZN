<?php

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="./stylesheets/login.css">
</head>
<body>
<nav>
<h1>Zorg Voor De Zorg Noura</h1>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="signup.php">Sign Up</a></li>
</ul>
</nav>


<div class="form">
    <div class="title">Welcome</div>
    <div class="subtitle">Fill in your details to login!</div>
    <div class="input-container ic1">
        <input id="firstname" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="firstname" class="placeholder">Email</label>
    </div>
    <div class="input-container ic2">
        <input id="lastname" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="lastname" class="placeholder">Password</label>
    </div>

    <button type="text" class="submit">submit</button>
    <p class="mb-0 mt-4 text-center"><a href="signup.php" class="link">Not registered yet? Sign Up here</a></p>
</div>
</body>
</html>

