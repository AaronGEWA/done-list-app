<?php
    echo "Login Page";
    $db = new PDO('sqlite:data.sqlite');
?>

<form method="post">
    <label for="name">Username:</label>
    <input type="text" id="name" name="username"><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="password"><br>
    <input type="submit" value="Login">
</form>

<?php
    
?>