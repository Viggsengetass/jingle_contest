<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un élève
    header('Location: login.php');
    exit();
}

// Vous pouvez ajouter ici le code pour afficher les jingles soumis par l'élève connecté

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord des élèves</title>
</head>
<body>
<h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
<!-- Affichez ici les jingles soumis par l'élève connecté -->
<?php
// Récupérez les jingles soumis par l'élève connecté à partir de la table "jingles"
$sql = "SELECT * FROM jingles WHERE student_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Mes jingles soumis :</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>{$row['jingle_title']} - <a href='{$row['jingle_file_path']}' target='_blank'>Écouter</a></p>";
    }
} else {
    echo "<p>Aucun jingle soumis pour le moment.</p>";
}
?>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
