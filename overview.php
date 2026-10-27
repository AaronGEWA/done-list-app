<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit("no verified session");
}
?>
<head>
    <style>
        form, table, h1, p {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<h1>Übersichtsseite</h1>
<p>
    <a href="new_entry.php"><button>Neues Projekt erfassen</button></a>
    <a href="export.php"><button>Exportieren</button></a>
</p>
<?php
    require('db.php');
    # Check and save an edited entry
    if (!empty($_POST["save_entry"])) {
        if ($_POST["status"] === "completed" AND !preg_match("/\d\d\d\d-\d\d-\d\d/", $_POST["date"])) {
            $_POST["edit_entry"] = $_POST["save_entry"];
            $save_failed = TRUE;
        } 
        # Check that all POST values match my expectations
        elseif (!is_string($_POST["title"]) || !is_string($_POST["description"]) || 
                !preg_match("/(completed)|(cancelled)/", $_POST["status"]) || 
                !preg_match("/(\d\d\d\d-\d\d-\d\d)|(^$)/", $_POST["date"])) {
            $_POST["edit_entry"] = $_POST["save_entry"];
            $save_failed = TRUE;
        }
        # Update the database
        else {
            $sql = 'UPDATE projects SET title=:title, description=:description, date_completed=:date, status=:status WHERE id=:id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':title', $_POST['title']);
            $stmt->bindValue(':description', $_POST['description']);
            if ($_POST["status"] === "completed") {
                $stmt->bindValue(':date', $_POST['date']);
            }
            $stmt->bindValue(':status', $_POST['status']);
            $stmt->bindValue(':id', intval($_POST['save_entry']));
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $save_failed = FALSE;
            }
        }
    }
    # Display all entries
    $sql = "SELECT * FROM projects ORDER BY date_completed NULLS LAST, id";
    $projects = $db->query($sql)->fetchAll();
    foreach ($projects as $row)  {
        if ($_POST["edit_entry"] != $row["id"]) {
            echo "<table style='margin-top:30px' id=T" . $row["id"] . ">";
            echo "<tr><th colspan='2'>" . htmlspecialchars($row['title']) . "</th></tr>";
            echo "<tr><td colspan='2' style='border-bottom: 1px solid #000;'>". htmlspecialchars($row['description']) . "</td></tr>";
            echo "<tr><td style='width:50%'>Status</td><td>" . $row['status'] . "</td></tr>";
            if ($row['status'] === "completed"){
                echo "<tr><td>Abschlussdatum</td><td>" . $row['date_completed'] . "</td></tr>";
            } 
            echo "</table>";

            echo '<form action="#T' . $row["id"] . '"  method="post">' . 
            '<input type="hidden" name="edit_entry" value="' . $row["id"] . '">' . 
            '<input type="submit" value="Bearbeiten">' . 
            '</form>';
            if ($_POST["save_entry"] == $row["id"]) {
                echo "<p style=\"color:green;\">Saved Changes!</p>";
            }
        } else {
            echo '<form method="post" style="margin-top:30px" id=T' . $row["id"] . '>' . 
            '<label for="title">Title:</label><br>' .
            '<input type="text" name="title" id="title" size="60" value="' . $row["title"] . '" required maxlength="64"><br>' .
            '<label for="desc">Description:</label><br>' .
            '<textarea name="description" id="desc" rows="8" cols="60" required maxlength="512">' . $row["description"] . '</textarea><br>' .
            '<label for="date">Date:</label><br>' .
            '<input type="date" name="date" id="date" value="' . $row["date_completed"] . '"><br>' .
            '<label for="status">Status:</label><br>' .
            '<input type="radio" name="status" id="completed" value="completed" required>' .
            '<label for="status">Completed</label><br>' .
            '<input type="radio" name="status" id="cancelled" value="cancelled" required>' .
            '<label for="status">Cancelled</label><br>' .
            '<input type="hidden" name="save_entry" value="' . $row["id"] . '">' .
            '<input type="submit" value="Speichern">' .
            '</form>';
            if ($save_failed) {
                echo "<p style=\"color:red;\">Invalid Input! Try again.</p>";
            }
        }
    }
?>