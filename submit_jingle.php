<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un élève
    header('Location: login.php');
    exit();
}

// Traitement du formulaire d'envoi du jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jingle_title = $_POST['jingle_title'];

    // Vérifiez si un fichier a été téléchargé
    if (isset($_FILES['jingle_file']) && $_FILES['jingle_file']['error'] === UPLOAD_ERR_OK) {
        $jingle_file_path = 'uploads/' . $_FILES['jingle_file']['name'];

        // Déplacez le fichier téléchargé vers le répertoire des téléchargements
        move_uploaded_file($_FILES['jingle_file']['tmp_name'], $jingle_file_path);

        // Enregistrez les détails du jingle dans la table "jingles"
        $student_id = $_SESSION['user_id'];
        $submission_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO jingles (student_id, jingle_title, jingle_file_path, submission_date)
                VALUES ('$student_id', '$jingle_title', '$jingle_file_path', '$submission_date')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success_message = "Votre jingle a été soumis avec succès !";
        } else {
            $error_message = "Une erreur s'est produite lors de la soumission de votre jingle. Veuillez réessayer.";
        }
    } else {
        $error_message = "Veuillez sélectionner un fichier pour votre jingle.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Déposer un jingle</title>
</head>
<body>
<h1>Déposer un jingle</h1>
<?php if (isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } elseif (isset($success_message)) { ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php } ?>
<form method="post" action="submit_jingle.php" enctype="multipart/form-data">
    <label for="jingle_title">Titre du jingle :</label>
    <input type="text" name="jingle_title" required><br>
    <label for="jingle_file">Fichier du jingle :</label>
    <input type="file" name="jingle_file" accept=".mp3" required><br>
    <input type="submit" value="Déposer le jingle">
</form>
<a href="student_dashboard.php">Retour au tableau de bord des élèves</a>
<a href="contest_stats.php">Voir les statistiques du concours</a>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
