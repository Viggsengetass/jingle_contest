<?php
session_start();
require_once('config.php');

if ($_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['jingle_id']) && isset($_POST['score'])) {
        $jingle_id = $_POST['jingle_id'];
        $score = $_POST['score'];
        $teacher_id = $_SESSION['user_id'];

        $insert_query = "INSERT INTO ratings (jingle_id, teacher_id, score) 
                         VALUES ('$jingle_id', '$teacher_id', '$score')";
        mysqli_query($conn, $insert_query);

        $update_query = "UPDATE jingles SET average_rating = 
                         (SELECT AVG(score) FROM ratings WHERE jingle_id = '$jingle_id') 
                         WHERE jingle_id = '".$jingle_id."'";
        mysqli_query($conn, $update_query);
    }

    if (isset($_POST['delete_comment_id'])) {
        $comment_id = $_POST['delete_comment_id'];
        $delete_query = "DELETE FROM comments WHERE comment_id = '$comment_id'";
        mysqli_query($conn, $delete_query);
    }

    if (isset($_POST['jingle_id']) && isset($_POST['comment'])) {
        $jingle_id = $_POST['jingle_id'];
        $comment = $_POST['comment'];
        $teacher_id = $_SESSION['user_id'];
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/teacher_dashboard.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Tableau de bord professeur</h1>

    <?php
    $query = "SELECT j.*, AVG(r.score) AS average_score 
              FROM jingles j 
              LEFT JOIN ratings r ON j.jingle_id = r.jingle_id
              GROUP BY j.jingle_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card mt-4'>";
            echo "<div class='card-header'>Jingle soumis par l'élève {$row['user_id']}: {$row['jingle_title']}</div>";
            echo "<div class='card-body'>";
            echo "<audio controls>";
            echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
            echo "Votre navigateur ne prend pas en charge l'élément audio.";
            echo "</audio>";
            $average_score = isset($row['average_score']) ? round($row['average_score'], 2) : "Aucune note";
            echo "<p>Note moyenne : {$average_score}</p>";
            echo "<form method='post' action='teacher_dashboard.php'>";
            echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
            echo "<label for='score'>Note :</label>";
            echo "<input type='number' name='score' min='0' max='10' required>";
            echo "<input type='submit' value='Noter'>";
            echo "</form>";
            echo "<form method='post' action='teacher_dashboard.php'>";
            echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
            echo "<label for='comment'>Commentaire :</label>";
            echo "<textarea name='comment' rows='3' required></textarea>";
            echo "<input type='submit' value='Commenter'>";
            echo "</form>";
            $comment_query = "SELECT c.*, u.first_name, u.last_name 
                              FROM comments c 
                              INNER JOIN users u ON c.teacher_id = u.user_id
                              WHERE c.jingle_id = '{$row['jingle_id']}'";
            $comment_result = mysqli_query($conn, $comment_query);
            if (mysqli_num_rows($comment_result) > 0) {
                echo "<h3>Commentaires et retours :</h3>";
                while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                    echo "<p>De : {$comment_row['first_name']} {$comment_row['last_name']}</p>";
                    echo "<p>{$comment_row['comment']}</p>";
                    echo "<form method='post' action='teacher_dashboard.php'>";
                    echo "<input type='hidden' name='delete_comment_id' value='{$comment_row['comment_id']}'>";
                    echo "<input type='submit' value='Supprimer ce commentaire'>";
                    echo "</form>";
                }
            }
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun jingle soumis pour le moment.</p>";
    }
    ?>

    <h2 class="mt-4">Créer un compte élève</h2>
    <form method="post" action="register_student.php">
        <div class="form-group">
            <label for="first_name">Prénom :</label>
            <input type="text" class="form-control" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Nom :</label>
            <input type="text" class="form-control" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer le compte élève</button>
    </form>

    <a href='logout.php' class="mt-4">Se déconnecter</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
