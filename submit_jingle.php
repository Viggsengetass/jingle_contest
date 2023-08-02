<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jingle_title = $_POST['jingle_title'];
    $jingle_file = $_FILES['jingle_file']['tmp_name'];
    $submission_date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];

    // Vérifiez le format du fichier audio (par exemple, uniquement les fichiers MP3 sont autorisés)
    $allowed_formats = ['mp3'];
    $file_info = pathinfo($_FILES['jingle_file']['name']);
    $file_extension = strtolower($file_info['extension']);

    if (!in_array($file_extension, $allowed_formats)) {
        $error_message = "Le format de fichier audio n'est pas autorisé. Veuillez soumettre un fichier MP3.";
    } else {
        // Déplacez le fichier audio soumis vers le dossier de destination sur le serveur
        $destination_folder = 'jingles/';
        $jingle_file_path = $destination_folder . $_SESSION['username'] . '_' . time() . '.mp3';
        move_uploaded_file($jingle_file, $jingle_file_path);

        // Enregistrez les informations du jingle dans la table "jingles"
        $sql = "INSERT INTO jingles (user_id, jingle_title, jingle_file_path, submission_date)
                VALUES ('$user_id', '$jingle_title', '$jingle_file_path', '$submission_date')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success_message = "Votre jingle a été soumis avec succès !";
        } else {
            $error_message = "Une erreur s'est produite lors de la soumission de votre jingle. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Envoyer un jingle</title>
</head>
<body>
    <h1>Envoyer un jingle</h1>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } elseif (isset($success_message)) { ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php } ?>
    <form method="post" action="submit_jingle.php" enctype="multipart/form-data">
        <label for="jingle_title">Titre du jingle :</label>
        <input type="text" name="jingle_title" required><br>
<label for="jingle_file">Fichier audio (format MP3) :</label>
        <input type="file" name="jingle_file" accept=".mp3" required><br>
        <input type="submit" value="Soumettre le jingle">
    </form>
</body>
</html>