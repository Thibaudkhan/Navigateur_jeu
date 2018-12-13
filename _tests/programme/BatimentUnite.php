<?php 
	require "Batiment.php";
	require "production.php";

	final class BatimentUnite extends Batiment implements production{ 

			protected $uniteProduite;

			public function __construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires,  $uniteProduite, $niveau, $materiaux, $etat) {
			parent::__construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires, $niveau, $materiaux, $etat);

			// Récupération des variables de la classe
			$this->setMateriauxProduits($uniteProduite);
			}

			public static function phrase(){
			echo "<br><br>Je suis un batiment de production "; 
		}

			// Fonction qui produit les ressources du batiment
			// Final : ne pourra pas être redéfinie
			final function produire(){ 
				$this->stock[$this->uniteProduite]+=(5*$this->niveau*$this->etatBat);
			}


	}