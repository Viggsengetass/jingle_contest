<?php
session_start();
require_once('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/index.css">

</head>
<body>
<!-- Barre de tâches -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav">
                <li><a href="index.php">Accueil</a></li>
                <?php
                // Afficher le lien vers le tableau de bord approprié en fonction du rôle de l'utilisateur
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'student') {
                    echo '<li><a href="student_dashboard.php">Tableau de bord étudiant</a></li>';
                } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher') {
                    echo '<li><a href="teacher_dashboard.php">Tableau de bord professeur</a></li>';
                }
                ?>
                <li><a href="public_rankings.php">Classement Public</a></li>
                <?php
                // Afficher le lien de déconnexion si l'utilisateur est connecté
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="logout.php">Se déconnecter</a></li>';
                } else {
                    echo '<li><a href="login.php">Se connecter</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1>Page d'accueil</h1>
    <p>Bienvenue sur notre plateforme de soumission de jingles !</p>
    <?php
    // Afficher un message de bienvenue si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        echo "<p>Bienvenue, {$_SESSION['username']} !</p>";
    }
    ?>
</div>

</body>
</html>
