<head>
    <style>
        form, h1, p {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<h1>Einträge Exportieren</h1>
<form method="post">
    <label for="s_date">Start Datum:</label><br>
    <input type="date" name="s_date" id="s_date" value="<?=$_POST["s_date"]?>"><br>
    <label for="e_date">End Datum:</label><br>
    <input type="date" name="e_date" id="e_date" value="<?=$_POST["e_date"]?>"><br>
    <input type="submit" name="action" value="Auswahl Exportieren"> <input type="submit" name="action" value="Alle Exportieren">
</form>
<?php
require('db.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["action"] === "Auswahl Exportieren") {    
        if (empty($_POST["s_date"])) {
            echo "<p>Start Datum angeben oder \"Alle Exportieren\" wählen</p>";
        }
        elseif (empty($_POST["e_date"])) {
            echo "<p>End Datum angeben oder \"Alle Exportieren\" wählen</p>";
        }
        elseif ($_POST["e_date"]<$_POST["s_date"]) {
            echo "<p>End Datum muss nach Start Datum sein!</p>";
        } 
        else {
            $sql = "SELECT * FROM projects WHERE date_completed<=:e_date AND date_completed>=:s_date ORDER BY date_completed";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':s_date', $_POST["s_date"]);
            $stmt->bindValue(':e_date', $_POST["e_date"]);
        }
    }
    elseif($_POST["action"] === "Alle Exportieren") {
        $sql = "SELECT * FROM projects ORDER BY date_completed, id";
        $stmt = $db->prepare($sql);
    }
    if(!empty($stmt)){
        $stmt->execute();
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = '{"exported_at": ' . date("Y-m-d") . ', "entries": [';
        foreach ($projects as $row) {
            $output .= json_encode($row);
        }
        $output .= "}]";
        echo $output;
        # TODO: Download as file
    }
}
?>