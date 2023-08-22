<?php
require_once('config.php');
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
        // Boucle pour afficher les jingles et le lecteur audio
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
            echo "<button class='play-pause-button' data-playing='false'>▶</button>"; // Bouton de lecture/pause personnalisé
<<<<<<< HEAD
            echo "<div class='timeline-container'>";
            echo "<div class='timeline'>";
            echo "<div class='progress-bar'></div>";
            echo "</div>";
            echo "<div class='timer'>00:00</div>";
            echo "</div>";
            echo "<button class='speed-button'>1x</button>"; // Bouton pour changer la vitesse de lecture
            echo "<a class='download-link' href='{$row['jingle_file_path']}' download>Télécharger</a>"; // Lien de téléchargement
            echo "</td>";
=======
            echo '</td>';
>>>>>>> parent of b229095 (fiix)
            echo "</tr>";
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
