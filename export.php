<head>
    <style>
        form, h1, p {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<h1>Einträge Exportieren</h1>
<p>
<a href="overview.php"><button>Zürück zur Übersicht</button></a>
</p>
<form method="post">
    <label for="s_date">Start Datum:</label><br>
    <input type="date" name="s_date" id="s_date" value="<?=$_POST["s_date"]?>"><br>
    <label for="e_date">End Datum:</label><br>
    <input type="date" name="e_date" id="e_date" value="<?=$_POST["e_date"]?>"><br>
    <label for="export">Export Format:</label><br>
    <input type="radio" name="export" id="json" value="json" required>
    <label for="json">JSON</label><br>
    <input type="radio" name="export" id="markdown" value="md" required>
    <label for="markdown">Markdown</label><br>
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
            $limited_export = TRUE;
        }
    }
    elseif($_POST["action"] === "Alle Exportieren") {
        $sql = "SELECT * FROM projects ORDER BY date_completed NULLS LAST, id";
        $stmt = $db->prepare($sql);
    }
    if(!empty($stmt)){
        $stmt->execute();
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($_POST["export"] === "json"){
            $output = '{"exported_at": "' . date("Y-m-d") . '", "entries": [';
            foreach ($projects as $row) {
                $output .= json_encode($row) . ',';
            }
            $output = rtrim($output, ',');
            $output .= "]}";
            file_put_contents('export.json', $output);
            echo "<p>Deine Einträge wurden exportiert!</p>";
            echo '<p><a href="export.json" download><button>Download JSON</button></a></p>';
        }
        if ($_POST["export"] === "md") {
            $date_format = "j F Y";
            $export = fopen("export.md", "w");
            $output = "# Übersicht Projekte  \n\nStand: " . date($date_format) . "  \n";
            if ($limited_export) {
                $s_date = strtotime($_POST["s_date"]);
                $e_date = strtotime($_POST["e_date"]);
                $output .= "Von: " . date($date_format, $s_date) . " bis: " . date($date_format, $e_date) . "  \n\n";
            }
            fwrite($export, $output);
            foreach ($projects as $row) {
                $output = "## " . $row["title"] . "  \n\n";
                $output .= $row["description"] . "  \n";
                if ($row["status"] === "completed") {
                    $output .= "\n---\n\nAbgeschlossen am: " . date($date_format, strtotime($row["date_completed"]));
                } else {
                    $output .= "\n---\n\nStatus: " . $row["status"];
                }
                $output .= "\n\n";
                fwrite($export, $output);
            }
            echo "<p>Deine Einträge wurden exportiert!</p>";
            echo '<p><a href="export.md" download><button>Download Markdown</button></a></p>';
        }
    }
}
?>