<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant que professeur
if ($_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

// Traitement de la notation d'un jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['jingle_id']) && isset($_POST['score'])) {
        $jingle_id = $_POST['jingle_id'];
        $score = $_POST['score'];

        // Effectuez ici la mise à jour de la notation dans la base de données
        // Utilisez la valeur de $jingle_id pour identifier le jingle et $score pour la note attribuée
        // Mettez à jour la table jingles avec la note donnée par le professeur
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord professeur</title>
</head>
<body>
<h1>Tableau de bord professeur</h1>

<!-- Afficher la liste des jingles soumis par les élèves -->
<?php
$query = "SELECT * FROM jingles";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>Jingle soumis par l'élève {$row['student_id']}: {$row['jingle_title']}</p>";
        echo "<audio controls>";
        echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
        echo "Votre navigateur ne prend pas en charge l'élément audio.";
        echo "</audio>";

        // Formulaire de notation du jingle
        echo "<form method='post' action='teacher_dashboard.php'>";
        echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
        echo "<label for='score'>Note :</label>";
        echo "<input type='number' name='score' min='0' max='10' required>";
        echo "<input type='submit' value='Noter'>";
        echo "</form>";
    }
} else {
    echo "<p>Aucun jingle soumis pour le moment.</p>";
}
?>
<!-- Formulaire pour créer un compte élève -->
<h2>Créer un compte élève</h2>
<form method="post" action="register_student.php">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Nom :</label>
    <input type="text" name="last_name" required><br>

    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" required><br>

    <input type="submit" value="Créer le compte élève">
</form>

<!-- Lien pour se déconnecter -->
<a href='logout.php'>Se déconnecter</a>
</body>
</html>
