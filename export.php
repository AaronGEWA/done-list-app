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
    <input type="date" name="s_date" id="s_date" value="<?=($_POST["s_date"])?>"><br>
    <label for="e_date">End Datum:</label><br>
    <input type="date" name="e_date" id="e_date" value="<?=$_POST["e_date"]?>"><br>
    <input type="submit" value="Export">
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    # Empty start and end dates export everything
    if (empty($_POST["s_date"])) {
        $_POST["s_date"] = "1900-01-01";
    }
    if (empty($_POST["e_date"])) {
        $_POST["e_date"] = "2100-01-01";
    }
    if ($_POST["e_date"]<$_POST["s_date"]) {
        echo "<p>End Datum muss nach Start Datum sein!</p>";
    } else {
        $sql = "SELECT * FROM projects WHERE abschlussdatum<=:e_date AND abschlussdatum>=:s_date";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':s_date', $_POST["s_date"]);
        $stmt->bindValue(':e_date', $_POST["e_date"]);
        $projects = $stmt->execute()->fetchAll();
        echo count($projects);
    }
}
?>