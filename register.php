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

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Requête pour insérer les informations de l'utilisateur dans la base de données
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, role)
            VALUES ('".$first_name."', '".$last_name."', '".$username."', '".$password."', '".$email."', '".$role."')";

    if (mysqli_query($conn, $sql)) {
        header('Location: login.php');
        exit();
    } else {
        $error_message = "Une erreur est survenue lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/register.css">
</head>
<body>
<div class="register-container">
    <h1 class="text-center">Inscription</h1>
    <form method="post" action="register.php">
        <div class="form-group">
            <label for="first_name">Prénom :</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Nom :</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role">Rôle :</label>
            <select name="role" class="form-control" required>
                <option value="student">Étudiant</option>
                <option value="teacher">Enseignant</option>
            </select>
        </div>

        <input type="submit" value="S'inscrire" class="btn btn-primary btn-block">
    </form>
    <p class="text-center mt-3">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    <?php
    if (isset($error_message)) {
        echo "<p class='text-danger mt-3'>{$error_message}</p>";
    }
    ?>
</div>
</body>
</html>