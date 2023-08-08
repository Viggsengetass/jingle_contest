<?php
// Connectez-vous à la base de données si ce n'est pas déjà fait
require_once('config.php');

// Récupérer les nouvelles notifications (par exemple, les nouveaux commentaires ou notes)
// en fonction de l'utilisateur (étudiant ou professeur) et les afficher sous forme d'éléments de liste
$user_id = $_SESSION['user_id'];

// Requête pour récupérer les nouvelles notifications, à personnaliser selon vos besoins
$query = "SELECT * FROM notifications WHERE user_id = '$user_id' AND is_read = 0";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>{$row['message']}</li>";

        // Marquer la notification comme lue
        $notification_id = $row['notification_id'];
        $update_query = "UPDATE notifications SET is_read = 1 WHERE notification_id = '$notification_id'";
        mysqli_query($conn, $update_query);
    }
} else {
    echo "<li>Pas de nouvelles notifications.</li>";
}
?>
