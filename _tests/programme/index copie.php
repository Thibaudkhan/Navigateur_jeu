<?php 

	session_start();

	require "BatimentDeProduction.php";
	require "Race.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		//Instanciation des objets
		$_SESSION['mine'] = new BatimentDeProduction("Fer",30,"Mine",3,"Fer",$niveau, Batiment::MATERIAU_BOIS, "neuf");
		$_SESSION['scierie'] = new BatimentDeProduction("Fer",20,"Scierie",2,"Bois",$niveau, Batiment::MATERIAU_PIERRE,"neuf");
		$romain = new Race("Romain",2,700);
		$gaulois = new Race("Gaulois",1,500);
		$germain = new Race("Germain",3,500);

		//Fonction affichage des caractéristiques
		$_SESSION['mine']->recap();
		$_SESSION['scierie']->recap();

		$romain->blabla();
		$gaulois->blabla();
		$germain->blabla();

		//Construit le batiment
		$_SESSION['mine']->constructionDuBatiment();

		//Affiche les ressources
		foreach ($_SESSION['mine']->getStock() as $key => $value) {
			echo '<br><br>';
			echo $key . ': ' . $value;
		}

		//Fonction statique
		BatimentDeProduction::texte();
		
	?>
	<script type="text/javascript" src="jquery.js"></script>
</body>
</html>