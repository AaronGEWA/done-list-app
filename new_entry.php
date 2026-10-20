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
        
    }
?>