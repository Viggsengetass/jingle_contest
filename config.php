<?php

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'jingle');
define('DB_PASSWORD', 'jingle');
define('DB_NAME', 'jingle');


$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("ERREUR : Impossible de se connecter. il y a une erreur" . mysqli_connect_error());
    echo "ERREUR : Impossible de se connecter. il y a une erreur";
} elseif ($conn) {
    //echo "Connexion réussie";
} else {
    echo "jsp moi";
}
?>