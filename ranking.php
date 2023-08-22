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
    echo "<div class='custom-audio-player'>";
    echo "<button class='play-pause-button' data-playing='false'></button>";
    echo "<div class='timeline-container'>";
    echo "<div class='timeline'>";
    echo "<div class='progress-bar'></div>";
    echo "</div>";
    echo "<div class='timer'>00:00</div>";
    echo "</div>";
    echo "<button class='speed-button'>1x</button>";
    echo "</div>";
    echo '</td>';
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