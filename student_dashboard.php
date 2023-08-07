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
    $student_id = $_SESSION['user_id'];
    $jingle_title = $_POST['jingle_title'];
    $submission_date = date('Y-m-d H:i:s');

    // Vérification du fichier téléchargé
    if ($_FILES['jingle_file']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['jingle_file']['tmp_name'];
        $file_name = basename($_FILES['jingle_file']['name']);
        $file_path = "uploads/{$file_name}";

        // Déplacer le fichier vers le répertoire de destination
        if (move_uploaded_file($tmp_name, $file_path)) {
            // Insérer le jingle dans la base de données
            $insert_query = "INSERT INTO jingles (student_id, jingle_title, jingle_file_path, submission_date) 
                             VALUES ('$student_id', '$jingle_title', '$file_path', '$submission_date')";
            mysqli_query($conn, $insert_query);
            $success_message = "Jingle soumis avec succès !";
        } else {
            $error_message = "Une erreur est survenue lors du téléchargement du fichier.";
        }
    } else {
        $error_message = "Une erreur est survenue lors du téléchargement du fichier.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord élève</title>
</head>
<body>
<h1>Tableau de bord élève</h1>

<!-- Afficher la liste des jingles soumis par l'élève -->
<?php
$student_id = $_SESSION['user_id'];
$query = "SELECT * FROM jingles WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Vos jingles soumis :</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>{$row['jingle_title']}</p>";
        echo "<audio controls>";
        echo "<source src='{$row['jingle_file_path']}' type='audio/mpeg'>";
        echo "Votre navigateur ne prend pas en charge l'élément audio.";
        echo "</audio>";
    }
} else {
    echo "<p>Aucun jingle soumis pour le moment.</p>";
}
?>

<!-- Formulaire pour soumettre un jingle -->
<h2>Soumettre un jingle</h2>
<form method="post" action="student_dashboard.php" enctype="multipart/form-data">
    <label for="jingle_title">Titre du jingle :</label>
    <input type="text" name="jingle_title" required><br>

    <label for="jingle_file">Fichier du jingle (format MP3) :</label>
    <input type="file" name="jingle_file" accept="audio/mpeg" required><br>

    <input type="submit" value="Soumettre le jingle">
</form>

<!-- Afficher les notes attribuées au jingle soumis par l'élève -->
<?php
$query = "SELECT r.score 
          FROM ratings r 
          INNER JOIN jingles j ON r.jingle_id = j.jingle_id
          WHERE j.student_id = '$student_id'";
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

<!-- Lien pour se déconnecter -->
<a href='logout.php'>Se déconnecter</a>

<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
if (isset($success_message)) {
    echo "<p>{$success_message}</p>";
}
?>
</body>
</html>
