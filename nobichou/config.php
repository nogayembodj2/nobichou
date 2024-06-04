<?php
$host = "";
$user = "root";
$password = "";
$database = "nobichou";

$mysqli = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
}
?>
