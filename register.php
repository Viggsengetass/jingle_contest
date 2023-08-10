<?php
session_start();
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    if (mysqli_query($conn, $query)) {
        $success_message = "Inscription réussie !";
    } else {
        $error_message = "Erreur lors de l'inscription.";
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
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <label for="role">Rôle :</label>
    <select name="role" required>
        <option value="student">Étudiant</option>
        <option value="teacher">Enseignant</option>
    </select><br>

    <input type="submit" value="S'inscrire">
</form>
<p><a href="login.php">Se connecter</a></p>
<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
if (isset($success_message)) {
    echo "<p>{$success_message}</p>";
}
?>
</body>
</html>
