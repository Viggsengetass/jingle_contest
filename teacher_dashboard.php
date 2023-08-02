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

// Vous pouvez également ajouter d'autres fonctionnalités spécifiques aux professeurs ici

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord des professeurs</title>
</head>
<body>
<h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
<!-- Affichez ici les informations spécifiques aux professeurs et les élèves inscrits -->
<!-- ... -->
<a href="register_student.php">Inscrire un nouvel élève</a>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
