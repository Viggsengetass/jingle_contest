<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant que professeur
if ($_SESSION['role'] !== 'teacher') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un professeur
    header('Location: login.php');
    exit();
}

// Vous pouvez ajouter ici le code pour afficher les élèves inscrits et leurs jingles soumis

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['evaluate_jingle'])) {
        $jingle_id = $_POST['jingle_id'];
        $evaluation = $_POST['evaluation'];

        // Mettez à jour l'évaluation du jingle dans la table "jingles"
        $sql = "UPDATE jingles SET evaluation = '$evaluation' WHERE jingle_id = $jingle_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success_message = "L'évaluation du jingle a été enregistrée avec succès !";
        } else {
            $error_message = "Une erreur s'est produite lors de l'enregistrement de l'évaluation. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord des professeurs</title>
</head>
<body>
<h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
<!-- Affichez ici les jingles soumis par les élèves avec des formulaires d'évaluation -->
<?php
// Récupérez tous les jingles soumis par les élèves à partir de la table "jingles"
$sql = "SELECT jingles.*, students.first_name, students.last_name FROM jingles
            INNER JOIN students ON jingles.student_id = students.student_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Évaluer les jingles soumis par les élèves :</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>{$row['jingle_title']} par {$row['first_name']} {$row['last_name']} - <a href='{$row['jingle_file_path']}' target='_blank'>Écouter</a></p>";
        echo "<form method='post' action='teacher_dashboard.php'>";
        echo "<input type='hidden' name='jingle_id' value='{$row['jingle_id']}'>";
        echo "Évaluation : <input type='number' name='evaluation' min='0' max='10' required>";
        echo "<input type='submit' name='evaluate_jingle' value='Évaluer'>";
        echo "</form>";
    }
} else {
    echo "<p>Aucun jingle soumis par les élèves pour le moment.</p>";
}
?>
<a href="register_student.php">Inscrire un nouvel élève</a>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
