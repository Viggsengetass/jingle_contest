<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté en tant que professeur
if ($_SESSION['role'] !== 'teacher') {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas un professeur
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Vérifiez si l'élève existe déjà dans la table "users" (en tant qu'élève ou professeur)
    $check_user_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_user_result = mysqli_query($conn, $check_user_sql);

    if (mysqli_num_rows($check_user_result) > 0) {
        $error_message = "Un utilisateur avec le même nom d'utilisateur ou la même adresse e-mail existe déjà.";
    } else {
        // Inscrivez l'élève dans la table "users" avec le rôle "student"
        $insert_user_sql = "INSERT INTO users (first_name, last_name, username, password, email, role)
                            VALUES ('$first_name', '$last_name', '$username', '$password', '$email', 'student')";
        $insert_user_result = mysqli_query($conn, $insert_user_sql);

        if ($insert_user_result) {
            $success_message = "L'élève a été inscrit avec succès !";
        } else {
            $error_message = "Une erreur s'est produite lors de l'inscription de l'élève. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription d'un nouvel élève</title>
</head>
<body>
<h1>Inscription d'un nouvel élève</h1>
<?php if (isset($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } elseif (isset($success_message)) { ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php } ?>
<form method="post" action="register_student.php">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" required><br>
    <label for="last_name">Nom :</label>
    <input type="text" name="last_name" required><br>
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" required><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>
    <label for="email">Adresse e-mail :</label>
    <input type="email" name="email" required><br>
    <input type="submit" value="Inscrire l'élève">
</form>
<a href="teacher_dashboard.php">Retour au tableau de bord des professeurs</a>
<a href="logout.php">Se déconnecter</a>
</body>
</html>
