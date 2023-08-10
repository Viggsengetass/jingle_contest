<?php
session_start();
require_once('config.php');

if ($_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['delete_jingle_id'])) {
    $jingle_id = $_GET['delete_jingle_id'];
    $student_id = $_SESSION['user_id'];

    $delete_query = "DELETE FROM jingles WHERE jingle_id = '$jingle_id' AND student_id = '$student_id'";
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
    <title>Supprimer le jingle</title>
</head>
<body>
<?php if (isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } elseif (isset($success_message)) { ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php } ?>
<?php if (isset($_GET['delete_jingle_id'])) { ?>
    <?php if (!isset($success_message)) { ?>
        <p>Voulez-vous vraiment supprimer ce jingle ?</p>
        <form method="post" action="delete_jingle.php?delete_jingle_id=<?php echo $_GET['delete_jingle_id']; ?>">
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
