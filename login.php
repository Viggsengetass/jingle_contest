<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est déjà connecté, s'il l'est, redirigez-le vers le tableau de bord approprié
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'student') {
        header('Location: student_dashboard.php');
    } elseif ($_SESSION['role'] === 'teacher') {
        header('Location: teacher_dashboard.php');
    }
    exit();
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour récupérer les informations de l'utilisateur à partir de la base de données
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Connexion réussie, définir les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Rediriger vers le tableau de bord approprié selon le rôle de l'utilisateur
            if ($user['role'] === 'student') {
                header('Location: student_dashboard.php');
            } elseif ($user['role'] === 'teacher') {
                header('Location: teacher_dashboard.php');
            }
            exit();
        } else {
            $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/login.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-container">
        <h1 class="text-center">Connexion</h1>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <input type="submit" value="Se connecter" class="btn btn-primary btn-block">
        </form>
        <p class="text-center mt-3">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
    </div>
</div>
<!--<a class="btn btn-primary" href="index.php">Retour à la page d'accueil</a>-->
</body>
</html>
