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
                         WHERE jingle_id = '".$jingle_id."'";
        mysqli_query($conn, $update_query);
    }

    // Traitement de la suppression de commentaire
    if (isset($_POST['delete_comment_id'])) {
        $comment_id = $_POST['delete_comment_id'];

        // Suppression du commentaire de la table comments
        $delete_query = "DELETE FROM comments WHERE comment_id = '$comment_id'";
        mysqli_query($conn, $delete_query);
    }

    // Traitement de la soumission de commentaire
    if (isset($_POST['jingle_id']) && isset($_POST['comment'])) {
        $jingle_id = $_POST['jingle_id'];
        $comment = $_POST['comment'];
        $teacher_id = $_SESSION['user_id'];

        // Insertion du commentaire dans la table comments
        $insert_query = "INSERT INTO comments (jingle_id, teacher_id, comment) 
                         VALUES ('$jingle_id', '$teacher_id', '$comment')";
        mysqli_query($conn, $insert_query);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord professeur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="teacher_dashboard.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Tableau de bord professeur</h1>
    echo '<div class="mt-4">';

        // Afficher la liste des jingles soumis par les élèves
        $query = "SELECT j.*, AVG(r.score) AS average_score
        FROM jingles j
        LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
        GROUP BY j.jingle_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="border p-3 mb-4">';
            echo "<p>Jingle soumis par l'élève {$row['user_id']}: {$row['jingle_title']}</p>";
            echo '<audio controls>';
                echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
                echo 'Votre navigateur ne prend pas en charge l\'élément audio.';
                echo '</audio>';

            // Afficher la note moyenne du jingle
            $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
            echo "<p>Note moyenne : {$average_score}</p>";

            // Formulaire de notation du jingle
            echo '<form method="post" action="teacher_dashboard.php" class="mb-2">';
                echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
                echo '<label for="score" class="me-2">Note :</label>';
                echo '<input type="number" name="score" min="0" max="10" required class="me-2">';
                echo '<input type="submit" value="Noter" class="btn btn-primary">';
                echo '</form>';

            // Formulaire de commentaire sur le jingle
            echo '<form method="post" action="teacher_dashboard.php">';
                echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
                echo '<label for="comment" class="me-2">Commentaire :</label>';
                echo '<textarea name="comment" rows="3" required class="me-2"></textarea>';
                echo '<input type="submit" value="Commenter" class="btn btn-primary">';
                echo '</form>';

            // Afficher les commentaires sur le jingle
            $comment_query = "SELECT c.*, u.first_name, u.last_name
            FROM comments c
            INNER JOIN users u ON c.teacher_id = u.user_id
            WHERE c.jingle_id = '{$row['jingle_id']}'";
            $comment_result = mysqli_query($conn, $comment_query);

            if (mysqli_num_rows($comment_result) > 0) {
            echo '<div class="mt-3">';
                echo '<h4>Commentaires et retours :</h4>';
                while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                echo '<div class="border p-2 mb-2">';
                    echo "<p>De : {$comment_row['first_name']} {$comment_row['last_name']}</p>";
                    echo "<p>{$comment_row['comment']}</p>";

                    // Formulaire de suppression de commentaire
                    echo '<form method="post" action="teacher_dashboard.php" class="d-inline">';
                        echo "<input type='hidden' name='delete_comment_id' value='{$comment_row['comment_id']}'>";
                        echo '<input type="submit" value="Supprimer ce commentaire" class="btn btn-danger">';
                        echo '</form>';
                    echo '</div>';
                }
                echo '</div>';
            }

            echo '</div>';
        }
        } else {
        echo '<p class="mt-4">Aucun jingle soumis pour le moment.</p>';
        }

        echo '</div>';
    ?>
    echo '<div class="mt-4">';

        // Formulaire pour créer un compte élève
        echo '<h2 class="mt-4">Créer un compte élève</h2>';
        echo '<form method="post" action="register_student.php" class="mb-4">';
            echo '<div class="mb-3">';
                echo '<label for="first_name" class="form-label">Prénom :</label>';
                echo '<input type="text" name="first_name" class="form-control" required>';
                echo '</div>';
            echo '<div class="mb-3">';
                echo '<label for="last_name" class="form-label">Nom :</label>';
                echo '<input type="text" name="last_name" class="form-control" required>';
                echo '</div>';
            echo '<div class="mb-3">';
                echo '<label for="username" class="form-label">Nom d\'utilisateur :</label>';
                echo '<input type="text" name="username" class="form-control" required>';
                echo '</div>';
            echo '<div class="mb-3">';
                echo '<label for="password" class="form-label">Mot de passe :</label>';
                echo '<input type="password" name="password" class="form-control" required>';
                echo '</div>';
            echo '<div class="mb-3">';
                echo '<label for="email" class="form-label">Email :</label>';
                echo '<input type="email" name="email" class="form-control" required>';
                echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Créer le compte élève</button>';
            echo '</form>';

        // Lien pour se déconnecter
        echo '<a href="logout.php" class="btn btn-danger">Se déconnecter</a>';

        echo '</div>';
    echo '</div>';
echo '</body>';
echo '</html>';
?>
echo '</div>';
} else {
echo '<p class="mt-4">Aucun jingle soumis pour le moment.</p>';
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '</body>';
echo '</html>';
?>
