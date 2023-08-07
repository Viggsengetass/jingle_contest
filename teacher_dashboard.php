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
        $teacher_id = $_SESSION['user_id'];

        // Insertion de la notation dans la table ratings
        $insert_query = "INSERT INTO ratings (jingle_id, teacher_id, score) 
                         VALUES ('$jingle_id', '$teacher_id', '$score')";
        mysqli_query($conn, $insert_query);

        // Calcul de la note moyenne et mise à jour dans la table jingles
        $update_query = "UPDATE jingles SET average_rating = 
                         (SELECT AVG(score) FROM ratings WHERE jingle_id = '$jingle_id') 
                         WHERE jingle_id = '$jingle_id'";
        mysqli_query($conn, $update_query);
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
$query = "SELECT j.*, AVG(r.score) AS average_score 
          FROM jingles j 
          LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
          GROUP BY j.jingle_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>Jingle soumis par l'élève {$row['student_id']}: {$row['jingle_title']}</p>";
        echo "<audio controls>";
        echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
        echo "Votre navigateur ne prend pas en charge l'élément audio.";
        echo "</audio>";

        // Afficher la note moyenne du jingle
        $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
        echo "<p>Note moyenne : {$average_score}</p>";

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
