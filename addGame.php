<!-- header -->
<?php
// on démarre la session ici
    session_start();
    $title = "Afficher jeux"; // title for current page
    include('partials/_header.php'); //include header
    // petit rappel: La combinaison en dessous permet de voir le lien parfait 
    //   echo $_SERVER['PHP_SELF']
    include('helpers/functions.php'); //include function
    // inclure PDO (pdo.php) pour la connexion à la BDD dans mon script
    require_once("helpers/pdo.php");
    // debug_array($_GET)  //on peut vérifier si ça prend bien enn compte dans le lien

    
    // 2ème partie après avoir créer la page on fait ça: création array error
    $error = [];
    // voir fichier fonction debug_array
    // debug_array($error);
    $errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";

    // variable success
    $success = false;

    // 1- Je vérifie que le btn submit fonctionnne en affichant un message echo"hourra"
    if(!empty($_POST["submited"])){
        // echo "tu as cliqué";// Lorsqu'on appuie sur le bouton en bas tu as cliqué doit apparaitre

        // 2- faille xss
        $nom = clear_xss($_POST["name"]);
        $prix = clear_xss($_POST["price"]);
        $note = clear_xss($_POST["note"]);
        $decription = clear_xss($_POST["description"]);
        
        // clear array genre with foreach
        $tableau_sale_de_genre = !empty($_POST["genre"]) ? $_POST["genre"] : [];
        // je crée un nouveau tableau pour les elements nettoyer
        $tableau_propre_de_genre = [];
        foreach ($tableau_sale_de_genre as $linge_sale) {
        // je lave chaque element et je l'insère dans le nouveau tableau
        $tableau_propre_de_genre[] = clear_xss($linge_sale);
        };
        
        // clear array plateforms with foreach
        $tableau_sale_platforms = $_POST["platforms"];
        // je crée un nouveau tableau pour les elements nettoyer
        $tableau_propre_de_plateforms = [];
        foreach ($tableau_sale_platforms as $linge_sale) {
        // je lave chaque element et je l'insere dans le nouveau tableau
        $tableau_propre_de_plateforms[] = clear_xss($linge_sale);
        };
        
        
        $pegi = clear_xss($_POST["pegi"]);
        // debug_array($_POST);

        
        // 3- validation de chaque input
        ////////////////////////////////
        // name
        if (!empty($name)) {
            if (
            strlen($name) <= 2
            ) {
                $error["name"] = "<span class=text-red-500>*3 caractères minimum</span>";
            } elseif (strlen($name) > 100) {
                $error["name"] = "<span class=text-red-500>*100 caractères maximum</span>";
            }
        } else {
            $error["name"] = $errorMessage;
        };

         // price
        if (!empty($prix)) {
            if (!is_numeric($prix) && is_float($prix)){
                $error["price"] = "<span class=text-red-500>Veuillez rentrer un nombre !</span>";
            } elseif (($prix) < 0) {
                $error["price"] = "<span class=text-red-500>Veuillez rentrer un prix supérieur à 0€</span>";
            } elseif (($prix) > 200) {
                $error["price"] = "<span class=text-red-500>Veuillez rentrer un prix inférieur à 200€</span>";   
            }
        } else {
            $error["price"] = $errorMessage;
        }

        //note
        if (!empty ($note)){
			if (is_numeric($note) && is_float($note)) {
				$error["note"] = "<span class=text-red-500>Veuillez rentrez un nombre</span>";
			}elseif (($note)<0) {
				$error["note"] = "<span class=text-red-500>Veuillez rentrez un chiffre supérieur à 0</span>";
			}elseif (($note)>200) {
				$error["note"] = "<span class=text-red-500>Veuillez rentrez un chiffre inférieur à 200</span>";
			}
        }else{
            $error["note"] = $errorMessage;
        }

        //genre
        if (!empty ($genre_clear)){
        debug_array ($genre_clear);
			if ($genre_clear == "Aventure" || $genre_clear == "Course" || $genre_clear == "FPS" || $genre_clear == "RPG") {
				echo "cool";
			}else {
				$error["genre"] = "Les éléments ne sont pas dans le tableau.";
			}
        }else{
            $error["genre"] = $errorMessage;
        }

         //description
		if (!empty($description)) {
			if (strlen($description)<=30) {
				$error["description"] = "<span class=text-danger>30 caractères minimum</span>";
			}elseif (strlen($nom)>300) {
				$error["description"] = "<span class=text-danger>120 caractères maximun</span>";
			}
		}else{
			$error["description"] = $errorMessage;
		}
        debug_array ($error);

    }
?>

<section class="py-12">
    <h1 class="text-blue-500 text-5xl text-center uppercase font-black pb-8">Add Game</h1>
    <form action="" method="POST">
        <!-- input for name -->
        <div class="mb-3">
            <label class="font-semibold text-blue-900" for="name">Nom</label>
            <input type="text" name="name" class="input input-bordered w-full max-w-xs block" value="<?php if (!empty($_POST["name"])){
                            echo $_POST["name"];
                          } ?>" />
            <p>
                <?php
				if(!empty($error["name"])){
					echo $error["name"];
				} ?>
            </p>           
        </div>

        <!-- input for price -->
        <div class="mb-3">
            <label class="font-semibold text-blue-900" for="price">Prix</label>
            <input type="number" step="0.01" name="price" placeholder="" class="input input-bordered w-full max-w-xs block"
            value="<?php if (!empty($_POST["price"])){
                            echo $_POST["price"];
                          } ?>" />
            <p>
                <?php
				if(!empty($error["price"])){
					echo $error["price"];
				} ?>
            </p>
        </div>

        <!-- input for genre -->
        <?php 
            $genreArray = [
                ["name" => "<strong>Aventure</strong>","checked"=>"checked"],
                ["name" => "Course"],
                ["name" => "FPS"],
                ["name" => "RPG"],
                ["name" => "Survival"],
            ];
        ?>
        <h2 class="font-semibold text-blue-900">Genre</h2>
        <div class="mt-5 mb-3 flex space-x-6">
            <?php foreach($genreArray as $genre) : ?>
            <div class="flex item-center space-x-3">
                <label for="genre" class="block font-semibold"><?= $genre["name"] ?></label>
                <input type="checkbox" name="genre[]" class="checkbox" value="<?= $genre["name"] ?>" <?= !empty ($genre ["checked"]) ? "checked" : ""; ?>/>
            </div>
            <?php endforeach ?>
        </div>
        <p class="">
                <?php
				if(!empty($error["genre"])){
					echo $error["genre"];
				} ?>
        </p>
        
        <!-- input for note -->
        <div class="mb-3">
            <label class="font-semibold text-blue-900" for="note">Note </label>
            <input type="number" step="0.1" name="note" class="input input-bordered w-full max-w-xs block" value="<?php if(!empty($_POST["note"])){echo $_POST["note"];} ?>" />
            <p>
                <?php
				if(!empty($error["note"])){
					echo $error["note"];
				} ?>
            </p>
        </div>

        <!-- input for plateforms -->
        <?php 
            $platformArray = [
                ["name" => "Switch"],
                ["name" => "PS3"],
                ["name" => "Xbox"],
                ["name" => "PS4"],
                ["name" => "PS5"],
                ["name" => "PC"],
                ["name" => "Mac"],
            ];
        ?>
        <h2 class="font-semibold text-blue-900">Plateforme</h2>
        <div class="mt-5 mb-3 flex space-x-6">
            <?php foreach($platformArray as $platform) : ?>
            <div class="flex item-center space-x-3">
                <label for="plateforms" class="block  font-semibold"><?= $platform["name"] ?></label>
                <!-- dans name="" mettre le même mots que celui de la base de donnée bdd de phpmyadmin -->
                <input type="checkbox" name="platforms[]" class="checkbox" value="<?= $platform["name"] ?>" <?= !empty ($plateform ["checked"]) ? "checked" : ""; ?> />
            </div>
            <?php endforeach ?>
        </div>

        <!-- input for description -->
        <div class="mb-3">
            <label class="font-semibold text-blue-900" for="description">Description </label>
            <textarea class="textarea textarea-bordered block" name="description" placeholder="" type="text" placehoder="Description du jeu" ><?php if(!empty($_POST["description"])){echo $_POST["description"];} ?></textarea>
            <p>
                <?php
				if(!empty($error["description"])){
					echo $error["description"];
				} ?>
            </p>
        </div>

        <!-- input for PEGI -->
        <?php 
            $pegiArray = [
                ["value" => 3],
                ["value" => 7],
                ["value" => 12],
                ["value" => 16],
                ["value" => 18],
            ];
        ?>
        <div class="">
        <h2 class="font-semibold text-blue-900 pt-4 pb-2">PEGI</h2>
            <select class="select select-bordered w-full max-w-xs" name="pegi">
                <option disabled selected>Choose PEGI</option>
                <!-- attention, bien mettre le foreach au bon endroit -->
                <?php foreach($pegiArray as $pegi) : ?> 
                <option value="<?= $pegi["value"] ?>"><?= $pegi["value"] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- button submit -->
        <div class="mt-4">
            <input type="submit" name="submited" value="Ajouter" class=" btn bg-blue-500">
        </div>


    </form>
</section>

<!-- footer -->
<?php 
    include('partials/_footer.php') //include footer
?> 