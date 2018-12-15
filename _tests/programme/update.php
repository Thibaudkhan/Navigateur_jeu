<?php 
	require "BatimentDeProduction.php";
	require "Race.php";

	session_start();

	//var_dump($_SESSION['mine']);

	$objetMine = $_SESSION['mine'];
	$objetScierie = $_SESSION['scierie'];

	//var_dump($objetMine);

	 if(isset($_POST['formData']) && !empty($_POST['formData'])) {
	 	$formData = $_POST['formData'];
	 		echo var_dump($objetMine->produire());
	 		echo var_dump($objetScierie->produire());
	 	}

	 
