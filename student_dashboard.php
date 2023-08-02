<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant qu'élève
if ($_SESSION['role'] !== 'student') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un élève
    header('Location: login.php');
    exit();
}

// Vous pouvez ajouter ici le code pour afficher les jingles soumis par l'élève

// Vous pouvez également ajouter d'autres fonctionnalités spécifiques aux élèves ici

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord des élèves</title>
</head>
<body>
<h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
<!-- Affichez ici les informations spécifiques aux élèves et les jingles soumis par l'élève -->
<!-- ... -->
<a href="logout.php">Se déconnecter</a>
</body>
</html>
