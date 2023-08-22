<?php
require_once('config.php');
$query = "SELECT u.username, j.*, AVG(r.score) AS average_score 
          FROM jingles j 
          LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
          INNER JOIN users u ON j.user_id = u.user_id
          GROUP BY j.jingle_id
          ORDER BY average_score DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Classement public des jingles par notation</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/ranking.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h1>Classement public des jingles par notation</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Numéro</th>
            <th>Titre du jingle</th>
            <th>Posté par</th>
            <th>Moyenne de notation</th>
            <th>Lien pour écouter</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $rank = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$rank}</td>"; // Numéro dans le classement
            echo "<td>{$row['jingle_title']}</td>";
            echo "<td>{$row['username']}</td>"; // Nom de l'utilisateur
            $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
            echo "<td>{$average_score}</td>";
            echo '<td class="audio-player">';
            echo "<audio controls>";
            echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
            echo "Votre navigateur ne prend pas en charge l'élément audio.";
            echo "</audio>";
            echo "<button class='play-pause-button' data-playing='false'></button>";
            echo "<div class='timeline-container'>";
            echo "<div class='timeline'>";
            echo "<div class='progress-bar'></div>";
            echo "</div>";
            echo "<div class='timer'>00:00</div>";
            echo "</div>";
            echo "<button class='speed-button'>1x</button>";
            echo "<button class='loop-button'>Boucle</button>"; // Bouton de bouclage
            echo "<a class='download-button' id='download-button' download='{$row['jingle_title']}.mp3'>Télécharger</a>"; // Bouton de téléchargement
            echo '</td>';
            echo "</tr>";
            $rank++;
        }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="index.php">Retour à la page d'accueil</a>
    <div class="visualizer-container">
        <canvas id="audio-visualizer"></canvas> <!-- Zone du visualiseur audio -->
    </div>
</div>
<script src="/js/ranking.js"></script>
</body>
</html>
