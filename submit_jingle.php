<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Traitement du formulaire de soumission de jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jingle_title = $_POST['jingle_title'];
    $jingle_file = $_FILES['jingle_file'];

    // Vérifiez si le fichier a été correctement téléchargé
    if ($jingle_file['error'] === UPLOAD_ERR_OK) {
        // Vérification du type de fichier
        $allowed_extensions = ['mp3'];
        $file_extension = strtolower(pathinfo($jingle_file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $error_message = "Seuls les fichiers MP3 sont autorisés.";
        } else {
            $jingle_tmp_name = $jingle_file['tmp_name'];
            $jingle_name = basename($jingle_file['name']);
            $jingle_path = 'data' . $jingle_name;

            // Afficher les informations du fichier
            echo "Jingle TMP Name: $jingle_tmp_name<br>";
            echo "Jingle Name: $jingle_name<br>";
            echo "Jingle Path: $jingle_path<br>";

            // Déplacez le fichier téléchargé vers son emplacement final
            if (move_uploaded_file($jingle_tmp_name, $jingle_path)) {
                // Enregistrez les informations du jingle dans la base de données
                $user_id = $_SESSION['user_id'];
                $submission_date = date('Y-m-d H:i:s');

                $sql = "INSERT INTO jingles (student_id, jingle_title, jingle_file_path, submission_date) 
                        VALUES ('$user_id', '$jingle_title', '$jingle_path', '$submission_date')";

                if (mysqli_query($conn, $sql)) {
                    header('Location: student_dashboard.php');
                    exit();
                } else {
                    $error_message = "Une erreur est survenue lors de l'enregistrement du jingle: " . mysqli_error($conn);
                }
            } else {
                $error_message = "Une erreur est survenue lors du téléchargement du fichier.";
            }
        }
    } else {
        $error_message = "Erreur lors du téléchargement du fichier (Code : {$jingle_file['error']})";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Soumettre un jingle</title>
</head>
<body>
<h1>Soumettre un jingle</h1>
<form method="post" action="submit_jingle.php" enctype="multipart/form-data">
    <label for="jingle_title">Titre du jingle :</label>
    <input type="text" name="jingle_title" required><br>

    <label for="jingle_file">Fichier du jingle (MP3 uniquement) :</label>
    <input type="file" name="jingle_file" accept=".mp3" required><br>

    <input type="submit" value="Soumettre">
</form>
<p><a href="student_dashboard.php">Retour au tableau de bord</a></p>
<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
?>
</body>
</html>
