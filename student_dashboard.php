<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

// Traitement de la soumission du jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $jingle_title = $_POST['jingle_title'];
    $submission_date = date('Y-m-d H:i:s');

    if ($_FILES['jingle_file']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['jingle_file']['tmp_name'];
        $file_name = basename($_FILES['jingle_file']['name']);
        $file_path = "data/{$file_name}";

        if (move_uploaded_file($tmp_name, $file_path)) {
            $insert_query = "INSERT INTO jingles (user_id, jingle_title, jingle_file_path, submission_date) 
                             VALUES ('$user_id', '$jingle_title', '$file_path', '$submission_date')";
            if (mysqli_query($conn, $insert_query)) {
                $success_message = "Jingle soumis avec succès !";
            } else {
                $error_message = "Erreur lors de l'insertion du jingle dans la base de données.";
            }
        } else {
            $error_code = $_FILES['jingle_file']['error'];
            $error_message = "Erreur lors du téléchargement du fichier (Code : $error_code)";
        }
    } else {
        $error_code = $_FILES['jingle_file']['error'];
        $error_message = "Erreur lors du téléchargement du fichier (Code : $error_code)";
    }
}

// Traitement de la suppression d'un jingle
if (isset($_GET['delete_jingle_id'])) {
    $user_id = $_SESSION['user_id'];
    $jingle_id = $_GET['delete_jingle_id'];

    $delete_query = "DELETE FROM jingles WHERE jingle_id = '$jingle_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        header('Location: student_dashboard.php');
        exit();
    } else {
        $error_message = "Erreur lors de la suppression du jingle.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord élève</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/student_dashboard.css">
    <script src="/js/student_dashboard.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="text-center mb-4">Tableau de bord élève</h1>

            <!-- Afficher la liste des jingles soumis par l'élève -->
            <?php
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM jingles WHERE user_id = '".$user_id."'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Vos jingles soumis :</h2>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>{$row['jingle_title']}</p>";
                    echo "<audio controls>";
                    echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
                    echo "Votre navigateur ne prend pas en charge l'élément audio.";
                    echo "</audio>";

                    // Ajouter un lien pour supprimer le jingle
                    echo "<a href='student_dashboard.php?delete_jingle_id={$row['jingle_id']}' class='btn btn-danger'>Supprimer ce jingle</a>";
                }
            } else {
                echo "<p>Aucun jingle soumis pour le moment.</p>";
            }
            ?>

            <!-- Formulaire pour soumettre un jingle -->
            <h2>Soumettre un jingle</h2>
            <form method="post" action="student_dashboard.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="jingle_title">Titre du jingle :</label>
                    <input type="text" name="jingle_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jingle_file">Fichier du jingle (format MP3) :</label>
                    <input type="file" name="jingle_file" accept="audio/mpeg" class="form-control-file" required>
                </div>

                <input type="submit" value="Soumettre le jingle" class="btn btn-primary">
            </form>

            <!-- Afficher les notes attribuées au jingle soumis par l'élève -->
            <?php
            $query = "SELECT r.score 
                      FROM ratings r 
                      INNER JOIN jingles j ON r.jingle_id = j.jingle_id
                      WHERE j.user_id = '$user_id'";
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

            <!-- Afficher les commentaires et retours sur les jingles -->
            <?php
            $comment_query = "SELECT c.comment, j.jingle_title 
                              FROM comments c 
                              INNER JOIN jingles j ON c.jingle_id = j.jingle_id
                              WHERE j.user_id = '$user_id'";
            $comment_result = mysqli_query($conn, $comment_query);

            if (mysqli_num_rows($comment_result) > 0) {
                echo "<h2>Commentaires et retours :</h2>";
                while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                    echo "<p>Titre du jingle : {$comment_row['jingle_title']}</p>";
                    echo "<p>Commentaire : {$comment_row['comment']}</p>";
                }
            } else {
                echo "<p>Aucun commentaire ou retour pour le moment.</p>";
            }
            ?>

            <!-- Section des notifications -->
            <div id="notifications" class="mt-5">
                <h2>Notifications</h2>
                <ul id="notification-list">
                    <!-- Les notifications seront ajoutées ici via AJAX -->
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
    // Fonction pour charger les nouvelles notifications via AJAX
    function loadNotifications() {
        $.ajax({
            url: 'get_notifications.php',
            // Remplacez par le chemin correct vers le script PHP qui récupère les notifications
            success: function(data) {
                $('#notification-list').html(data);
            }
        });
    }

    // Charger les notifications au chargement de la page et toutes les 30 secondes
    $(document).ready(function() {
        loadNotifications();
        setInterval(loadNotifications, 30000); // Rafraîchir toutes les 30 secondes
    });
</script>

<!-- Lien pour se déconnecter -->
<div id="wrap-btn">
<a href='logout.php' class="btn btn-secondary mt-3">Se déconnecter</a>
</div>
<?php
if (isset($error_message)) {
    echo "<p class='text-danger mt-3'>{$error_message}</p>";
}
if (isset($success_message)) {
    echo "<p class='text-success mt-3'>{$success_message}</p>";
}
?>

</body>
</html>

