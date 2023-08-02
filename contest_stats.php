<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève ou professeur
if ($_SESSION['role'] !== 'student' && $_SESSION['role'] !== 'teacher') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header('Location: login.php');
    exit();
}

// Récupérez les statistiques du concours
$sql = "SELECT COUNT(*) AS total_jingles FROM jingles";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_jingles = $row['total_jingles'];

$sql = "SELECT COUNT(*) AS total_evaluated_jingles FROM jingles WHERE evaluation IS NOT NULL";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_evaluated_jingles = $row['total_evaluated_jingles'];

// Vous pouvez également ajouter d'autres statistiques, telles que la moyenne des évaluations, etc.

?>
<!DOCTYPE html>
<html>
<head>
    <title>Statistiques du concours</title>
</head>
<body>
<h1>Statistiques du concours de sonnerie</h1>
<p>Total des jingles soumis : <?php echo $total_jingles; ?></p>
<p>Total des jingles évalués : <?php echo $total_evaluated_jingles; ?></p>
<!-- Ajoutez ici d'autres statistiques si vous le souhaitez -->
<?php if ($_SESSION['role'] === 'teacher') { ?>
    <a href="teacher_dashboard.php">Retour au tableau de bord des professeurs</a>
<?php } elseif ($_SESSION['role'] === 'student') { ?>
    <a href="student_dashboard.php">Retour au tableau de bord des élèves</a>
<?php } ?>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
