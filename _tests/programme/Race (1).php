<?php
	class Race {

		//Variables :
		protected $nomRace;
		protected $niveauDuBatiment = 1;
		protected $gold = 500;

		//Constructeur :
		function __construct($nomRace, $niveauDuBatiment,$gold) {
			$this->setNomRace($nomRace);
			$this->setNiveauDuBatiment($niveauDuBatiment);
			$this->setGold($gold);

		}

		//Setteurs :
		public function setNomRace($nomRace) {
		if(!in_array($nomRace, ['Romain', 'Gaulois','Germain'])) { 
			trigger_error("Race inexistante", E_USER_WARNING);
			return;
			}
			$this->nomRace = $nomRace;
		}
		public function setNiveauDuBatiment($niveauDuBatiment) {
			if(!in_array($niveauDuBatiment, [1, 2, 3, 4])) { 
			trigger_error("Les batiments peuvent être du niveau 1 à 4", E_USER_WARNING);
			return;
			}
			$this->niveauDuBatiment = $niveauDuBatiment;
		}
		public function setGold($gold) {
			if($gold < 500) { 
			trigger_error("Impossible Gold < 500", E_USER_WARNING);
			return;
			}
			$this->gold = $gold;
		}

		//Getteurs :
		public function getNomRace(){
			return $this->nomRace;
		}
		public function getNiveauDuBatiment(){
			return $this->niveauDuBatiment;
		}
		public function getGold(){
			return $this->gold;
		}

		//Fonction pour afficher les caractéristiques de l'objet
		public function blabla() {
			echo "<br><br>";
			echo "Tu es un ". $this->getNomRace().", ton niveau de batiment est ".$this->getNiveauDuBatiment() ." et tu as ". $this->getGold() ." or.";
		}
	}
 ?>