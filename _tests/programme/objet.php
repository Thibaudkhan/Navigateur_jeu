<?php 
	class BatimentDeProduction{ //On créé la classe batiment de production 


		// Variables :
		protected $materiauxNecessaires;
		protected $tempsDeConstruction;
		protected $nomDuBatiment;
		protected $ouvriersNecessaires;

		protected $materiauxProduits;

		protected $niveau;
		protected $etat = "neuf";
		protected $etatBat;
		// Constructeur :

		public function __construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires, $materiauxProduits, $niveau){

			// Récupération des variables de la classe

			$this->setMateriauxNecessaires($materiauxNecessaires);
			$this->setTempsDeConstruction($tempsDeConstruction);
			$this->setNomDuBatiment($nomDuBatiment);
			$this->setOuvriersNecessaires($ouvriersNecessaires);
			$this->setMateriauxProduits($materiauxProduits);
			$this->setNiveau($niveau);
		}


		// Setteurs :

		// Permet d'attribuer des valeurs à nos variables
		public function setMateriauxNecessaires($materiauxNecessaires){
			if(!in_array($materiauxNecessaires, ['Bois', 'Fer'])) { 
				trigger_error("Lalala vous n'avez pas les matériaux nécessaires", E_USER_WARNING);
				return;
				}
			$this->materiauxNecessaires = $materiauxNecessaires;
		}
		public function setTempsDeConstruction($tempsDeConstruction){
			if($tempsDeConstruction<0) {
				trigger_error('Non');
				return;
			}
			$this->tempsDeConstruction = $tempsDeConstruction;
		}
		public function setNomDuBatiment($nomDuBatiment){
			if(!in_array($nomDuBatiment, ['Mine','Scierie'])) {
				trigger_error("Donne lui un nom père indigne !");
				return;
			}
			$this->nomDuBatiment = $nomDuBatiment;
		}
		public function setOuvriersNecessaires($ouvriersNecessaires){
			if($ouvriersNecessaires<0) {
				trigger_error("Comment tu veux avoir un batiment sans main d'oeuvre ?");
				return;
			}

			if($ouvriersNecessaires>6) {
				trigger_error("Le communisme n'est qu'une utopie");
				return;
			}
			$this->ouvriersNecessaires = $ouvriersNecessaires;
		}
		public function setMateriauxProduits($materiauxProduits){
			if(!in_array($materiauxProduits, ['Bois', 'Fer'])) { 
				trigger_error("Lalala vous n'avez pas les matériaux nécessaires", E_USER_WARNING);
				return;
			}
			$this->materiauxProduits = $materiauxProduits;
		}
		public function setNiveau($niveau){
			if($niveau<0) {
				trigger_error("Mec sérieusement, niveau négatif ?");
				return;
			}
			$this->niveau = $niveau;
		}

		//getter :

		// récupère la valeur de nos petites variables
		public function getMateriauxNecessaires(){
			return $this->materiauxNecessaires;
		}
		public function getTempsDeConstruction(){
			return $this->tempsDeConstruction;
		}
		public function getNomDuBatiment(){
			return $this->nomDuBatiment;
		}
		public function getOuvriersNecessaires(){
			return $this->ouvriersNecessaires;
		}
		public function getMateriauxProduits(){
			return $this->materiauxProduits;
		}
		public function getNiveau(){
			return $this->niveau;
		}

		public function recap(){
			echo '---- RECAP ----- <br />';
			echo "Le batiment " . $this->getNomDuBatiment() . " a besoin de ". $this->getMateriauxNecessaires() ." et de ". $this->getOuvriersNecessaires() ." ouvriers, pour etre construit en ". $this->getTempsDeConstruction() ."sec , il produit du ". $this->getMateriauxProduits() ;
		}

	}


?>