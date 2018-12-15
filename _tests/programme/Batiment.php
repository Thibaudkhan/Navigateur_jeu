<?php
	//Class abstraites
	//Abstraite : ne peut pas être instanciée
	abstract class Batiment{

		//Constantes :
		const MATERIAU_PIERRE 	= "#8B8C7A";
		const MATERIAU_BOIS 	= "#DEB887";
		const MATERIAU_BRIQUE 	= "#B22222";

		//Variables :
		protected $materiaux;
		protected $materiauxNecessaires;
		protected $tempsDeConstruction;
		protected $nomDuBatiment;
		protected $ouvriersNecessaires;
		protected $niveau = 1;
		protected $stock = array("Bois"=>500, "Fer"=>700);
		protected $etatBat;
		protected $etat = "neuf";

		//Constructeur :
		public function __construct($materiauxNecessaires, $tempsDeConstruction, $nomDuBatiment, $ouvriersNecessaires, $niveau, $materiaux, $etat){

			// Récupération des variables de la class
			$this->setMateriauxNecessaires($materiauxNecessaires);
			$this->setTempsDeConstruction($tempsDeConstruction);
			$this->setNomDuBatiment($nomDuBatiment);
			$this->setOuvriersNecessaires($ouvriersNecessaires);
			$this->setNiveau($niveau);
			$this->setMateriaux($materiaux);
			$this->setEtat($etat);

		}

		//Fonction statique
		public static function texte(){
			static::phrase();
		}
		public static function phrase(){
			echo "<br><br>Je suis un batiment ◊"; 
		}

		//Fonction finale
		final function constructionDuBatiment() {
			if ($this->stock[$this->materiauxNecessaires]>100) {
			$this->stock[$this->materiauxNecessaires]-=100;
			} else {
				echo "Vous n'avez pas assez de " . $this->materiauxNecessaires;
				}
		}

		//Setteurs :
		public function setEtat($etat){ 
			if ($etat == "neuf") {
				$etatBat = 1;
			} else {
				$etat ="detruit";
				$etatBat = 0;
			}
		}

		public function setMateriaux($materiaux){
			$array_materiaux = [self::MATERIAU_BRIQUE, self::MATERIAU_BOIS, self::MATERIAU_PIERRE];
			if(!in_array($materiaux, $array_materiaux)){
				trigger_error("Je suis un coq ©", E_USER_WARNING); 
			return;
			}
			$this->materiaux = $materiaux;
		}

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
		
		public function setNiveau($niveau){
			if($niveau<1) {
				trigger_error("Mec sérieusement, niveau négatif ?");
				return;
			}
			$this->niveau = $niveau;
		}

		public function setStock($stock){
			$this->stock['Fer'] = $stock['Fer'];
			$this->stock['Bois'] = $stock['Bois'];
		}

		//Getteurs :

		//Récupère la valeur de nos petites variables
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
		public function getNiveau(){
			return $this->niveau;
		}
		public function getStock(){
			return $this->stock;
		}
		public function getMateriaux(){
			return $this->materiaux;
		}
		public function getEtat(){
			return $this->etat;
		}
	}
?>