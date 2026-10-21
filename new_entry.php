<head>
    <style>
        form, h1 {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>

<form method="post">
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" size="60" value="<?=$_POST["title"]?>" required maxlength="64"><br>
    <label for="desc">Description:</label><br>
    <textarea name="description" id="desc" rows="8" cols="60" required maxlength="512"><?=$_POST["description"]?></textarea><br>
    <label for="date">Date:</label><br>
    <input type="date" name="date" id="date" value="<?=$_POST["date"]?>"><br>
    <label for="status">Status:</label><br>
    <input type="radio" name="status" id="completed" value="completed" required>
    <label for="status">Completed</label><br>
    <input type="radio" name="status" id="cancelled" value="cancelled" required>
    <label for="status">Cancelled</label><br>
    <input type="submit" value="Create">
</form>

<?php
    require('db.php');
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        if ($_POST["status"] === "completed" AND !preg_match("/\d\d\d\d-\d\d-\d\d/", $_POST["date"])) {
            echo "<p style=\"color:red;\">Complete Entries must have a completion date!</p>";
        } 
        # Check that all POST values match my expectations
        elseif (!is_string($_POST["title"]) || !is_string($_POST["description"]) || 
                !preg_match("/(completed)|(cancelled)/", $_POST["status"]) || 
                !preg_match("/(\d\d\d\d-\d\d-\d\d)|(^$)/", $_POST["date"])) {
            echo "<p style=\"color:red;\">Invalid Input! Try again.</p>";
        }
        else {
            $sql = "INSERT INTO projects (title, description, abschlussdatum, status) VALUES (:title, :description, :abschlussdatum, :status)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':title', $_POST['title']);
            $stmt->bindValue(':description', $_POST['description']);
            if ($_POST["status"] === "completed") {
                $stmt->bindValue(':abschlussdatum', $_POST['date']);
            }
            $stmt->bindValue(':status', $_POST['status']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                echo "<p style=\"color:green;\">Entry added!</p>";
            }
        }
    }
?>