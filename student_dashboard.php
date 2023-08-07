<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord élève</title>
</head>
<body>
<h1>Tableau de bord élève</h1>

<!-- Afficher la liste des jingles soumis par l'élève -->
<?php
$student_id = $_SESSION['user_id'];
$query = "SELECT * FROM jingles WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Vos jingles soumis :</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>{$row['jingle_title']}</p>";
        echo "<audio controls>";
        echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
        echo "Votre navigateur ne prend pas en charge l'élément audio.";
        echo "</audio>";
    }
} else {
    echo "<p>Aucun jingle soumis pour le moment.</p>";
}
?>

<!-- Afficher les notes attribuées au jingle soumis par l'élève -->
<?php
$query = "SELECT r.score 
          FROM ratings r 
          INNER JOIN jingles j ON r.jingle_id = j.jingle_id
          WHERE j.student_id = '$student_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Vos notes :</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>Note : {$row['score']}</p>";
    }
} else {
    echo "<p>Aucune note attribuée à votre jingle pour le moment.</p>";
}
?>

<!-- Lien pour se déconnecter -->
<a href='logout.php'>Se déconnecter</a>
</body>
</html>
