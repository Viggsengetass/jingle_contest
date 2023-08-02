<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un élève
    header('Location: login.php');
    exit();
}

// Vérifiez si un jingle_id est passé en paramètre dans l'URL
if (isset($_GET['jingle_id'])) {
    $jingle_id = $_GET['jingle_id'];

    // Vérifiez si le jingle appartient bien à l'élève connecté
    $sql = "SELECT * FROM jingles WHERE jingle_id = $jingle_id AND student_id = {$_SESSION['user_id']}";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // Supprimez le fichier audio du jingle du répertoire "uploads/"
        $row = mysqli_fetch_assoc($result);
        $jingle_file_path = $row['jingle_file_path'];
        if (unlink($jingle_file_path)) {
            // Supprimez le jingle de la table "jingles"
            $delete_sql = "DELETE FROM jingles WHERE jingle_id = $jingle_id";
            $delete_result = mysqli_query($conn, $delete_sql);

            if ($delete_result) {
                $success_message = "Le jingle a été supprimé avec succès !";
            } else {
                $error_message = "Une erreur s'est produite lors de la suppression du jingle. Veuillez réessayer.";
            }
        } else {
            $error_message = "Une erreur s'est produite lors de la suppression du fichier du jingle. Veuillez réessayer.";
        }
    } else {
        $error_message = "Vous n'êtes pas autorisé à supprimer ce jingle.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supprimer le jingle</title>
</head>
<body>
<?php if (isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } elseif (isset($success_message)) { ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php } ?>
<?php if (isset($_GET['jingle_id'])) { ?>
    <?php if (!isset($success_message)) { ?>
        <p>Voulez-vous vraiment supprimer ce jingle ?</p>
        <form method="post" action="delete_jingle.php?jingle_id=<?php echo $jingle_id; ?>">
            <input type="submit" value="Oui">
        </form>
    <?php } ?>
    <a href="student_dashboard.php">Retour au tableau de bord des élèves</a>
    <a href="logout.php">Se déconnecter</a>
<?php } else { ?>
    <p>Le jingle spécifié n'existe pas ou vous n'êtes pas autorisé à le supprimer.</p>
    <a href="student_dashboard.php">Retour au tableau de bord des élèves</a>
<?php } ?>
</body>
</html>
