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

    // ... Votre code de traitement ici ...

    // Rediriger après le traitement
    header('Location: student_dashboard.php');
    exit();
}

// Traitement de la suppression d'un jingle
if (isset($_GET['delete_jingle_id'])) {
    $user_id = $_SESSION['user_id'];
    $jingle_id = $_GET['delete_jingle_id'];

    // ... Votre code de traitement ici ...

    // Rediriger après le traitement
    header('Location: student_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord élève</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/student_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
            // ... Votre code pour afficher les notes attribuées ...
            ?>

            <!-- Afficher les commentaires et retours sur les jingles -->
            <?php
            // ... Votre code pour afficher les commentaires et retours ...
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
            url: 'get_notifications.php', // Remplacez par le chemin correct vers le script PHP qui récupère les notifications
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
<a href='logout.php' class="btn btn-secondary mt-3">Se déconnecter</a>

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
