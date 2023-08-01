<?php
session_start();
require('config.php');
if (isset($_SESSION["username"])) {
    header("Location: /first/first.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/MDB5-Pro-6.1.0/plugins/css/all.min.css">
    <link rel="stylesheet" href="assets/MDB5-Pro-6.1.0/css/mdb.dark.min.css">
    <title></title>
</head>
<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
<?php
include('assets/includes/Header.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($conn, htmlspecialchars(hash('sha256', $_POST['password'])));
    if ($email !== "" && $password !== "") {
        $requete = "SELECT count(*) FROM users where email ='" . $email . "' and password='" . $password . "'";
        $exec_requete = mysqli_query($conn, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if ($count == 1) { // nom d'utilisateur et mot de passe correctes

            $requete = "SELECT * FROM users where email ='" . $email . "' and password='" . $password . "'";
            $exec_requete = mysqli_query($conn, $requete);
            $reponse = mysqli_fetch_array($exec_requete);
            $username = $reponse['username'];
            $email = $reponse['email'];
            $role = $reponse['role'];
            $id = $reponse['id'];
            $Etat = $reponse['Etat'];
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;
            $_SESSION['Etat'] = $Etat;
            header('Location: first/first.php');
        } else {
            echo '<form method="POST">
                 <h4 style="color: red;">email ou mot de passe incorect</h4>
                 <div class="form-group">
                    <label for="exampleInputEmail1">email</label>
                    <input type="text" class="form-control" id="Inputusername" aria-describedby="" name="email" placeholder="email" required>
                 </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                 </div>
                 <button type="submit" class="btn btn-primary">Connexion</button>
                 </form>
                 </body>
                 </html>';
        }
    }
}else{
?>
<form method="POST">
    <div class="form-group">
        <label for="Inputusername">email</label>
        <input type="text" class="form-control" id="Inputusername" aria-describedby="" name="email" placeholder="email"
               required>
    </div>
    <div class="form-group">
        <label for="InputPassword">Password</label>
        <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password"
               required>
    </div>
    <button type="submit" class="btn btn-primary">Connexion</button>
</form>
<script type="text/javascript" src="assets/MDB5-Pro-6.1.0/js/mdb.min.js"></script>
<!-- MDB PLUGINS -->
<script type="text/javascript" src="assets/MDB5-Pro-6.1.0/plugins/js/all.min.js"></script>
</body>
</html>
<?php
}
?>
