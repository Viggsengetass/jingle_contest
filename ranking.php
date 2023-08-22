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
        require_once('config.php');

        $query = "SELECT u.username, j.*, AVG(r.score) AS average_score 
                          FROM jingles j 
                          LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
                          INNER JOIN users u ON j.user_id = u.user_id
                          GROUP BY j.jingle_id
                          ORDER BY average_score DESC";
        $result = mysqli_query($conn, $query);

        $rank = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$rank}</td>"; // Numéro dans le classement
            echo "<td>{$row['jingle_title']}</td>";
            echo "<td>{$row['username']}</td>"; // Nom de l'utilisateur
            $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
            echo "<td>{$average_score}</td>";
            echo "<td>";
            echo '<div id="app-cover">';
            echo '<div id="bg-artwork"></div>';
            echo '<div id="bg-layer"></div>';
            echo '<div id="player">';
            echo '<div id="player-track">';
            echo '<div id="album-name"></div>';
            echo '<div id="track-name"></div>';
            echo '<div id="track-time">';
            echo '<div id="current-time"></div>';
            echo '<div id="track-length"></div>';
            echo '</div>';
            echo '<div id="s-area">';
            echo '<div id="ins-time"></div>';
            echo '<div id="s-hover"></div>';
            echo '<div id="seek-bar"></div>';
            echo '</div>';
            echo '</div>';
            echo '<div id="player-content">';
            echo '<div id="album-art">';
            echo "<img src='{$row['jingle_file_path']}' class='active'>";
            echo '</div>';
            echo '<div id="player-controls">';
            echo '<div class="control">';
            echo '<div class="button" id="play-previous">';
            echo '<i class="fas fa-backward"></i>';
            echo '</div>';
            echo '</div>';
            echo '<div class="control">';
            echo '<div class="button" id="play-pause-button">';
            echo '<i class="fas fa-play"></i>';
            echo '</div>';
            echo '</div>';
            echo '<div class="control">';
            echo '<div class="button" id="play-next">';
            echo '<i class="fas fa-forward"></i>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $rank++;
        }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="index.php">Retour à la page d'accueil</a>
</div>

<script src="/js/ranking.js"></script>
</body>
</html>
