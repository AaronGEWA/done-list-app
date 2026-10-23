<head>
    <style>
        table, h1, p {
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
    # Display all entries here
    $sql = "SELECT * FROM projects ORDER BY date_completed, id";
    $projects = $db->query($sql)->fetchAll();
    foreach ($projects as $row)  {
        echo "<table style='margin-bottom:30px'>";
        echo "<tr><th colspan='2'>" . htmlspecialchars($row['title']) . "</th></tr>";
        echo "<tr><td colspan='2' style='border-bottom: 1px solid #000;'>". htmlspecialchars($row['description']) . "</td></tr>";
        echo "<tr><td style='width:50%'>Status</td><td>" . $row['status'] . "</td></tr>";
        if ($row['status'] === "completed"){
            echo "<tr><td>Abschlussdatum</td><td>" . $row['date_completed'] . "</td></tr>";
        } 
        echo "</table>";
    }
?>