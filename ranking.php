<?php
session_start();
require_once('config.php');

$query = "SELECT j.*, AVG(r.score) AS average_score 
          FROM jingles j 
          LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
          GROUP BY j.jingle_id
          ORDER BY average_score DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Classement des jingles par notation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Classement des jingles par notation</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Titre du jingle</th>
            <th>Moyenne de notation</th>
            <th>Lien pour écouter</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['jingle_title']}</td>";
            $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
            echo "<td>{$average_score}</td>";
            echo "<td><audio controls>";
            echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
            echo "Votre navigateur ne prend pas en charge l'élément audio.";
            echo "</audio></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="teacher_dashboard.php">Retour au tableau de bord professeur</a>
    <a href="logout.php">Se déconnecter</a>
</div>
</body>
</html>
