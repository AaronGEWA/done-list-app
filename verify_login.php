<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    require('db.php');
    $sql = "SELECT * FROM user WHERE username=:username";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($user) && password_verify($_POST["password"], $user["password_hash"])) {
        $_SESSION["username"] = $user["username"];
        header("Location: overview.php");
    } else {
        header("Location: index.php");
    }
}
?>