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
</head>
<body>
<h1>Inscription</h1>
<form method="post" action="register.php">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Nom :</label>
    <input type="text" name="last_name" required><br>

    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" required><br>

    <label for="role">Rôle :</label>
    <select name="role" required>
        <option value="student">Étudiant</option>
        <option value="teacher">Enseignant</option>
    </select><br>

    <input type="submit" value="S'inscrire">
</form>
<p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
?>
</body>
</html>
