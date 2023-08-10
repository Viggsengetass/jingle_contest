<?php
session_start();
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'student') {
                header('Location: student_dashboard.php');
            } elseif ($user['role'] === 'teacher') {
                header('Location: teacher_dashboard.php');
            }
            exit();
        } else {
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        $error_message = "Nom d'utilisateur incorrect.";
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
<p><a href="register.php">S'inscrire</a></p>
<?php
if (isset($error_message)) {
    echo "<p>{$error_message}</p>";
}
?>
</body>
</html>
