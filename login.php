<?php
session_start();
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Recherchez l'utilisateur dans la table "users" en utilisant son nom d'utilisateur et mot de passe
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // L'utilisateur est connecté avec succès, enregistrez ses informations dans la session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $username;

        if ($user['role'] === 'student') {
            // Redirigez l'élève vers le tableau de bord des élèves
            header('Location: student_dashboard.php');
            exit();
        } elseif ($user['role'] === 'teacher') {
            // Redirigez le professeur vers le tableau de bord des professeurs
            header('Location: teacher_dashboard.php');
            exit();
        }
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
</head>
<body>
<h1>Connexion</h1>
<?php if (isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
<?php } ?>
<form method="post" action="login.php">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Se connecter">
</form>
<form method="post" action="login.php">
    <!-- Utilisé pour permettre aux professeurs de créer des comptes pour les élèves -->
    <input type="hidden" name="create_student_account" value="1">
    <input type="submit" value="Se connecter en tant que professeur">
</form>
<!-- Lien pour accéder à la page d'inscription des élèves (réservé aux professeurs) -->
<a href="register_student.php">Inscrire un nouvel élève</a>
</body>
</html>
