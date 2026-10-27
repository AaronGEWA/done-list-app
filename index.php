<head>
    <style>
        form, h1, p {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>

<?php
    echo "<h1>Registrierungsseite </h1>";
    require('db.php');
?>

<form method="post">
    <label for="name">Username:</label>
    <input type="text" id="name" name="username" required><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="password" required><br>
    <input type="submit" value="Register">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    #Verify that username and password are good
    if (empty($_POST["username"])) {
        echo '<p>Username darf nicht leer sein!</p>';
    }
    elseif (empty($_POST["password"])) {
        echo '<p>Password darf nicht leer sein!</p>';
    }
    else {
        if (strlen($_POST["password"])<6) {
            echo '<p>Passwort ist zu kurz</p>';
        }
        else {
            # Only one user allowed
            $sql = 'DELETE FROM user';
            $db->exec($sql);
            $sql = 'INSERT INTO user VALUES (:username, :password)';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":username", $_POST["username"]);
            $pwd_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $stmt->bindValue(":password", $pwd_hash);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                echo '<p>Neuer Benutzer wurde registriert!</p>';
            }
        }
    }
}
?>