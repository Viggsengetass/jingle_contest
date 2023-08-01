<?php

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'g4_genshin');
define('DB_PASSWORD', 'g4_genshin');
define('DB_NAME', 'g4_genshin');


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