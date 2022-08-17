<?php
// 1 on définie les variables suivantes ($blabla)
$serveur = "localhost";
$dbname = "app_game";
$login = "root";
$password = ""; // pour windows "", pour mac "root" ici c'est windows

try {
    $pdo = new PDO("mysql:host=$serveur;dbname=$dbname", $login, $password, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        // Ne pas récupérer les élements dupliqués (qui sont en double)
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Pour afficher les errors 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
    // affiche un message ok connexion
    // echo "Connexion établie !";


} catch (PDOException $e) {
   echo "Erreur de connexion: ".$e->getMessage(); 
}
