<?php
    echo "<h1> Login Page </h1>";
    $db = new PDO('sqlite:data.sqlite');
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE TABLE IF NOT EXISTS "projects" (
	"id" INTEGER NOT NULL UNIQUE,
	"title" TEXT NOT NULL,
	"description" TEXT NOT NULL,
	"abschlussdatum" DATE,
	"status" TEXT NOT NULL,
	PRIMARY KEY("id")
    );';
    $db->exec($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS "user" (
	"username" TEXT NOT NULL UNIQUE,
	"password_hash" TEXT NOT NULL,
	PRIMARY KEY("username")
    );';
    $db->exec($sql);
    $sql = "INSERT INTO user (username, password_hash) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    #$stmt->execute(["Aaron3", "Test"]);
?>

<form method="post">
    <label for="name">Username:</label>
    <input type="text" id="name" name="username"><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="password"><br>
    <input type="submit" value="Login">
</form>

<?php
# Just for testing, change later!
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        echo htmlspecialchars($_POST['username']);
    }
    $user = $db->query('SELECT * FROM "user"')->fetch();
    var_dump($user);
?>