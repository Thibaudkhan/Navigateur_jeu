<?php 
	require "BatimentDeProduction.php";
	require "Race.php";

	session_start();

	//var_dump($_SESSION['mine']);

	$monobjet = $_SESSION['mine'];

	//var_dump($monobjet);

	 $monobjet->produire();

	 if(isset($_POST['formData']) && !empty($_POST['formData'])) {
	 	$formData = $_POST['formData'];
	 	switch($formData) {
	 		case 'produire' : 
	 			echo $monobjet->produire();
	 			echo $monobjet->getStock();
	 			break;
	 		case 'other' : echo 'mdr';break;
	 	}
	 }