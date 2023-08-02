// register_student.php
<?php
session_start();
require_once('config.php');

// Vérifier si l'utilisateur connecté est un professeur
if ($_SESSION['role'] !== 'teacher') {
    // Redirigez l'utilisateur vers le tableau de bord approprié (élève ou professeur)
    if ($_SESSION['role'] === 'student') {
        header('Location: student_dashboard.php');
    } else {
        header('Location: teacher_dashboard.php');
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations du nouvel élève à partir du formulaire d'inscription
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Insérer les informations du nouvel élève dans la table "users" avec le rôle "student"
    $sql = "INSERT INTO users (role, first_name, last_name, username, password, email)
            VALUES ('student', '$first_name', '$last_name', '$username', '$password', '$email')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $success_message = "Le compte de l'élève a été créé avec succès !";
    } else {
        $error_message = "Une erreur s'est produite lors de la création du compte de l'élève. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscrire un nouvel élève</title>
</head>
<body>
<h1>Inscrire un nouvel élève</h1>
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
    <label for="email">Email :</label>
    <input type="email" name="email" required><br>
    <input type="submit" value="Inscrire l'élève">
</form>
</body>
</html>
