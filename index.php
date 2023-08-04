<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concours de Sonnerie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label, select, input[type="text"], input[type="password"], input[type="email"], input[type="submit"] {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }
        select, input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Concours de Sonnerie</h1>
    <form method="post" action="register.php">
        <label for="first_name">Prénom :</label>
        <input type="text" name="first_name" required>

        <label for="last_name">Nom :</label>
        <input type="text" name="last_name" required>

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>

        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <label for="role">Rôle :</label>
        <select name="role" required>
            <option value="">Sélectionner un rôle</option>
            <option value="student">Élève</option>
            <option value="teacher">Professeur</option>
        </select>

        <input type="submit" value="S'inscrire">
    </form>
    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
</div>
</body>
</html>
