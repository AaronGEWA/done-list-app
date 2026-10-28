<head>
    <link rel="stylesheet" href="style.css">
</head>

<?php
    echo "<h1> Login Page </h1>";
    require('db.php');
?>

<form method="post" action="../verify_login.php">
    <label for="name">Username:</label>
    <input type="text" id="name" name="username" required><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="password" required><br>
    <input type="submit" value="Login">
</form>

<?php
if (!empty($_GET["verify"]) && $_GET["verify"] === "false") {
    echo '<p style="color:red;">Wrong Username or Password!</p>'; 
}
?>