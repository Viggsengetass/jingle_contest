<?php
session_start();
require_once('config.php');

// Vérifier le rôle de l'utilisateur
if ($_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

// Traitement de la notation d'un jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jingle_id']) && isset($_POST['score'])) {
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

// Traitement de la soumission de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jingle_id']) && isset($_POST['comment'])) {
    $jingle_id = $_POST['jingle_id'];
    $comment = $_POST['comment'];
    $teacher_id = $_SESSION['user_id'];

    // Insertion du commentaire dans la table comments
    $insert_query = "INSERT INTO comments (jingle_id, teacher_id, comment) 
                     VALUES ('$jingle_id', '$teacher_id', '$comment')";
    mysqli_query($conn, $insert_query);
}

// Fonction pour afficher les commentaires
function displayComments($conn, $jingle_id) {
    $comment_query = "SELECT c.*, u.first_name, u.last_name 
                      FROM comments c 
                      INNER JOIN users u ON c.teacher_id = u.user_id
                      WHERE c.jingle_id = '$jingle_id'";
    $comment_result = mysqli_query($conn, $comment_query);

    if (mysqli_num_rows($comment_result) > 0) {
        echo "<h3>Commentaires et retours :</h3>";
        while ($comment_row = mysqli_fetch_assoc($comment_result)) {
            echo "<p>De : {$comment_row['first_name']} {$comment_row['last_name']}</p>";
            echo "<p>{$comment_row['comment']}</p>";
        }
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

        // Formulaire de commentaire sur le jingle
        echo "<form method='post' action='teacher_dashboard.php'>";
        echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
        echo "<label for='comment'>Commentaire :</label>";
        echo "<textarea name='comment' rows='3' required></textarea>";
        echo "<input type='submit' value='Commenter'>";
        echo "</form>";

        // Afficher les commentaires sur le jingle
        displayComments($conn, $row['jingle_id']);
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
