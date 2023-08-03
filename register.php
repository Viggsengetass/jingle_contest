<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Vérification des données saisies (vous pouvez ajouter plus de validation ici)
    if (empty($first_name) || empty($last_name) || empty($username) || empty($password) || empty($email) || empty($role)) {
        $error_message = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Vérification si l'utilisateur existe déjà
        $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Le nom d'utilisateur ou l'email est déjà utilisé.";
        } else {
            // Hashage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer les informations du nouvel utilisateur dans la table "users"
            $sql = "INSERT INTO users (first_name, last_name, username, password, email, role)
                    VALUES ('$first_name', '$last_name', '$username', '$hashed_password', '$email', '$role')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Rediriger l'utilisateur vers la page de connexion après l'inscription réussie
                header('Location: login.php');
                exit();
            } else {
                $error_message = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
            }
        }
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
        <option value="">Sélectionner un rôle</option>
        <option value="student">Élève</option>
        <option value="teacher">Professeur</option>
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
