<?php
// 6a- On démarre la session une fois les 5 parties faites
session_start();

include('helpers/functions.php'); //include function
// 1- connection à ma BDD
// inclure PDO (pdo.php) pour la connexion à la BDD dans mon script
require_once("helpers/pdo.php");

// 2- Je récupère id dans URL et je nettoie
$id = clear_xss($_GET["id"]);

// 3- requête vers BDD
$sql = "DELETE FROM jeux WHERE id=?";

// 4- Je prépare ma requête (query)
$query = $pdo->prepare($sql);

// 5- On execute la requête (query)
$query->execute([$id]);

// 6b- redirection (suite de la session)
$_SESSION["success"] = "Le jeu est supprimé ! ";
header("Location:index.php");