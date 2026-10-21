<head>
    <style>
        table, h1 {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<h1>Übersichtsseite</h1>

<?php
    require('db.php');
    # Display all entries here
    $sql = "SELECT * FROM projects";
    $projects = $db->query($sql)->fetchAll();
    foreach ($projects as $row)  {
        echo "<table>";
        echo "<tr><th colspan='2'>" . htmlspecialchars($row['title']) . "</th></tr>";
        echo "<tr><td colspan='2' style='border-bottom: 1px solid #ddd;'>". htmlspecialchars($row['description']) . "<td>";
        echo "<tr><td>Status</td><td>" . $row['status'] . "</td></tr>";
        if ($row['status'] === "completed"){
            echo "<tr><td>Abschlussdatum</td><td>" . $row['abschlussdatum'] . "</td></tr>";
        }   
        echo "</table><p></p>";
    }
?>