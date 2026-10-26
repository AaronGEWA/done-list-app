<head>
    <style>
        form, h1 {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>

<?php
    echo "<h1> Login Page </h1>";
    require('db.php');
?>

<form method="post" action="verify_login.php">
    <label for="name">Username:</label>
    <input type="text" id="name" name="username" required><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="password" required><br>
    <input type="submit" value="Login">
</form>

<?php

?>