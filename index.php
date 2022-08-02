<!-- header -->
<?php
// on démarre la session ici
session_start();
  $title = "Accueil"; // title for current page
  include('partials/_header.php'); //include header
  include('helpers/functions.php'); //include function
    // petit rappel: La combinaison en dessous permet de voir le lien parfait 
  //   echo $_SERVER['PHP_SELF']

    // inclure PDO (pdo.php) pour la connexion à la BDD dans mon script
    require_once("helpers/pdo.php");
    
    // 1- Requête pour récupérer mes jeux / Query to get all games
    $sql =  "SELECT * FROM  jeux"; //si l'on veut plus spécifique on remplace * par name, genre...
    // 2- Prépare la requête (preformater la requête)
    $query = $pdo->prepare($sql);
    // 3- execute ma requête
    $query->execute();
    // 4- On stocke ma requête dans une variable / stock my query in variable
    $games = $query->fetchAll();
    // debug_array($games); //affiche le tabelau avec tous les objets

?>
    
<!-- main content -->
<div class=" pt-16 wrap_content" >
    <!-- head content -->
    <div class=" wrap_content-head text-center">
        <h1 class="text-blue-500 text-5xl text-center uppercase font-black"> App game</h1>
        <p>L'app qui répertorie vos jeux</p>
        
        <?php
        // Je vérifie que session error est vide ou pas
        if ($_SESSION["error"]) { ?>
            <div class="bg-red-400 text-white">
                <?= $_SESSION["error"] ?>
            </div>
        <?php } 
        // Je vide ma variable $_SESSION["error"] pour qu'il n'affihe pas de message en créant un array vide
        $_SESSION["error"] = []; ?>
        
    </div>
    
    <!-- table -->
    <div class="overflow-x-auto mt-16">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Genre</th>
                    <th>Plateforme</th>
                    <th>Prix</th>
                    <th>PEGI</th>
                    <th>voir</th>
                </tr>
            </thead>
            <tbody>
                
                    
                <?php 
                if(count($games) == 0 ) {
                    echo"<tr><td class='text-center'>Pas de jeux disponibles actuellement</td></tr>";
                } else { ?>
                    <?php foreach($games as $game): ?>
                    <tr>
                        <th><?= $game['id'] ?></th>
                        <td><?= $game['name'] ?></td>
                        <td><?= $game['genre'] ?></td>
                        <td><?= $game['plateforms'] ?></td>
                        <td><?= $game['price'] ?></td>
                        <td><?= $game['PEGI'] ?></td>
                        <td>
                            <a href="show.php?id=<?=$game['id'] ?>&name=<?= $game['name']?>&genre=<?= $game['genre']?>"> 
                                <img src="img/loupe.png" alt="loupe" class="w-4">
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <!-- http://localhost/php/app_game/show.php -->
                <?php } ?>
                        
                    
                
            
            <!-- row 1 -->
                <!-- <tr>
                    <th>1</th>
                    <td>Mario</td>
                    <td>Plateforme</td>
                    <td>Switch</td>
                    <td>33.99</td>
                    <td>3</td>
                    <td>
                        <a href="show.php"> 
                            <img src="img/loupe.png" alt="loupe" class="w-4">
                        </a>
                    </td>
                 </tr> -->
      
            </tbody>
        </table>
    </div>
    
</div>
<!-- end main content -->

<!-- footer -->
<?php 
    include('partials/_footer.php') //include footer
?> 