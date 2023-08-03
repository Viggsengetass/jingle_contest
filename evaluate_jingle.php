<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant que professeur
if ($_SESSION['role'] !== 'teacher') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un professeur
    header('Location: login.php');
    exit();
}

// Vérifiez si un jingle_id est passé en paramètre dans l'URL
if (isset($_GET['jingle_id'])) {
    $jingle_id = $_GET['jingle_id'];

    // Récupérez les détails du jingle depuis la table "jingles"
    $sql = "SELECT * FROM jingles WHERE jingle_id = $jingle_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $jingle = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Le jingle spécifié n'existe pas.";
    }
}

// Traitement du formulaire d'évaluation du jingle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evaluation = $_POST['evaluation'];

    // Mettez à jour l'évaluation du jingle dans la table "jingles"
    $sql = "UPDATE jingles SET evaluation = $evaluation WHERE jingle_id = $jingle_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $success_message = "L'évaluation du jingle a été enregistrée avec succès !";
    } else {
        $error_message = "Une erreur s'est produite lors de l'enregistrement de l'évaluation. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Évaluer le jingle</title>
</head>
<body>
<?php if (isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } elseif (isset($success_message)) { ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php } ?>
<?php if (isset($jingle)) { ?>
    <h1>Évaluer le jingle</h1>
    <p>Titre du jingle : <?php echo $jingle['jingle_title']; ?></p>
    <p>Écouter le jingle : <audio controls><source src="<?php echo $jingle['jingle_file_path']; ?>" type="audio/mpeg"></audio></p>
    <form method="post" action="evaluate_jingle.php?jingle_id=<?php echo $jingle_id; ?>">
        <label for="evaluation">Évaluation (sur 10) :</label>
        <input type="number" name="evaluation" min="0" max="10" required><br>
        <input type="submit" value="Enregistrer l'évaluation">
    </form>
<?php } else { ?>
    <p>Le jingle spécifié n'existe pas.</p>
<?php } ?>
<a href="teacher_dashboard.php">Retour au tableau de bord des professeurs</a>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
