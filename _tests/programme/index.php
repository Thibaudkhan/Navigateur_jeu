<?php 

	require "BatimentDeProduction.php";
	require "Race.php";

	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		//Instanciation des objets
		$mine = new BatimentDeProduction("Fer",30,"Mine",3,"Fer", 2, Batiment::MATERIAU_BOIS, "neuf");
		$scierie = new BatimentDeProduction("Fer",20,"Scierie",2,"Bois", 7, Batiment::MATERIAU_PIERRE,"neuf");
		$romain = new Race("Romain",2,700);
		$gaulois = new Race("Gaulois",1,500);
		$germain = new Race("Germain",3,500);

		//Fonction affichage des caractéristiques
		$mine->recap();
		$scierie->recap();
		$romain->blabla();
		$gaulois->blabla();
		$germain->blabla();

		//Construit le batiment
		$mine->constructionDuBatiment();
		$scierie->constructionDuBatiment();

		//Affiche les ressources
		foreach ($mine->getStock() as $key => $value) {
			echo '<br><br>';
			echo $key . ': ' . $value;
		}

		//Fonction statique
		BatimentDeProduction::texte();

		$_SESSION['mine'] = $mine;
		$_SESSION['scierie'] = $scierie;
		
	?>

<div id="ressources"></div>

	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>