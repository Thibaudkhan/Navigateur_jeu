<?php 
	require "Batiment.php";
	require "production.php";

	//On crée la classe batiment de production 
	final class BatimentDeProduction extends Batiment implements production{ 

		// Variables :
		protected $materiauxProduits;
	
		// Constructeur :
		public function __construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires,  $materiauxProduits, $niveau, $materiaux, $etat) {
			parent::__construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires, $niveau, $materiaux, $etat);

			// Récupération des variables de la classe
			$this->setMateriauxProduits($materiauxProduits);
		}

		//Affiche la static du batiment de production
		//Static : déclarée dans la classe mère et modifiée dans la classe fille
		public static function phrase(){
			echo "<br><br>Je suis un batiment de production "; 
		}

		// Fonction qui produit les ressources du batiment
		// Final : ne pourra pas être redéfinie
		final function produire(){ 
			$this->stock[$this->materiauxProduits]+=(50*$this->niveau*$this->etatBat);
		}

		// Set et Get les matériaux que produit le batiment :
		public function setMateriauxProduits($materiauxProduits){
			if(!in_array($materiauxProduits, ['Bois', 'Fer'])) { 
				trigger_error("Lalala vous n'avez pas les matériaux ", E_USER_WARNING);
				return;
			}
			$this->materiauxProduits = $materiauxProduits;
		}

		public function getMateriauxProduits(){
			return $this->materiauxProduits;
		}

		// Permet d'attribuer des valeurs à nos variables
		public function recap(){
			echo "<br><br>Le batiment " . $this->getNomDuBatiment() . " a besoin de ". $this->getMateriauxNecessaires() ." et de ". $this->getOuvriersNecessaires() ." ouvriers, pour etre construit en ". $this->getTempsDeConstruction() ."sec , il produit du ". $this->getMateriauxProduits(). " et son niveau est ". $this->getNiveau() . ".<br /><br />La couleur du matériaux sur le batiment est : " . $this->getMateriaux() . ".<br /><br />L'état du batiment est : " . $this->getEtat();
		}
	}
?>