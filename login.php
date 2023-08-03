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
</head>
<body>
<h1>Connexion</h1>
<form method="post" action="login.php">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Se connecter">
</form>
<p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
?>
</body>
</html>
