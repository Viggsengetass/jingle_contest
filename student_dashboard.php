<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord élève</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/student_dashboard.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="text-center mb-4">Tableau de bord élève</h1>

            <div class="jingles-section">
                <h2>Vos jingles soumis :</h2>
                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM jingles WHERE user_id = '".$user_id."'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='jingle-item'>";
                        echo "<p class='jingle-title'>{$row['jingle_title']}</p>";
                        echo "<audio controls>";
                        echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
                        echo "Votre navigateur ne prend pas en charge l'élément audio.";
                        echo "</audio>";
                        echo "<a href='student_dashboard.php?delete_jingle_id={$row['jingle_id']}' class='btn btn-danger'>Supprimer ce jingle</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucun jingle soumis pour le moment.</p>";
                }
                ?>
            </div>

            <div class="submit-jingle-section">
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
            </div>

            <div class="ratings-section">
                <h2>Vos notes :</h2>
                <?php
                $query = "SELECT r.score 
                          FROM ratings r 
                          INNER JOIN jingles j ON r.jingle_id = j.jingle_id
                          WHERE j.user_id = '$user_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p class='rating'>Note : {$row['score']}</p>";
                    }
                } else {
                    echo "<p>Aucune note attribuée à votre jingle pour le moment.</p>";
                }
                ?>
            </div>

            <div class="comments-section">
                <h2>Commentaires et retours :</h2>
                <?php
                $comment_query = "SELECT c.comment, j.jingle_title 
                                  FROM comments c 
                                  INNER JOIN jingles j ON c.jingle_id = j.jingle_id
                                  WHERE j.user_id = '$user_id'";
                $comment_result = mysqli_query($conn, $comment_query);

                if (mysqli_num_rows($comment_result) > 0) {
                    while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                        echo "<div class='comment-item'>";
                        echo "<p class='jingle-title'>Titre du jingle : {$comment_row['jingle_title']}</p>";
                        echo "<p class='comment'>Commentaire : {$comment_row['comment']}</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucun commentaire ou retour pour le moment.</p>";
                }
                ?>
            </div>

            <div id="notifications" class="notifications-section">
                <h2>Notifications</h2>
                <ul id="notification-list">
                    <!-- Les notifications seront ajoutées ici via AJAX -->
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
    function loadNotifications() {
        $.ajax({
            url: 'get_notifications.php',
            success: function(data) {
                $('#notification-list').html(data);
            }
        });
    }

    $(document).ready(function() {
        loadNotifications();
        setInterval(loadNotifications, 30000);
    });
</script>

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
