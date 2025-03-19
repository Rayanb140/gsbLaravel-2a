<?php
namespace App\MyApp;
use PDO;
use Illuminate\Support\Facades\Config;
class PdoGsb{
        private static string $serveur;
        private static string $bdd;
        private static mixed $user;
        private static mixed $mdp;
        private  $monPdo;

/**
 * crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	public function __construct(){

        self::$serveur='mysql:host=' . Config::get('database.connections.mysql.host');
        self::$bdd='dbname=' . Config::get('database.connections.mysql.database');
        self::$user=Config::get('database.connections.mysql.username') ;
        self::$mdp=Config::get('database.connections.mysql.password');
        $this->monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp);
  		$this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		$this->monPdo =null;
	}


   /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, visiteur.mdp as mdp_hash 
		from visiteur where visiteur.login = :login";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':login', $login);
		$stmt->execute();
		$ligne = $stmt->fetch();
		
		if ($ligne && password_verify($mdp, $ligne['mdp_hash'])) {
			unset($ligne['mdp_hash']);
			return $ligne;
		}
		return false;
	}

    /**
     * Retourne les informations d'un gestionnaire
     * @param $login
     * @param $mdp
     * @return mixed l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosGestionnaire($login, $mdp){
        $req = "select gestionnaire.id as id, gestionnaire.nom as nom, gestionnaire.prenom as prenom, gestionnaire.mdp as mdp_hash 
        from gestionnaire where gestionnaire.login = :login";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $ligne = $stmt->fetch();
        
        if ($ligne && password_verify($mdp, $ligne['mdp_hash'])) {
            unset($ligne['mdp_hash']);
            return $ligne;
        }
        return false;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
     *  concernées par les deux arguments
     *
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return array|false l'id, le libelle et la quantité sous la forme d'un tableau associatif
     */
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
		order by lignefraisforfait.idfraisforfait";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->bindParam(':mois', $mois);
		$stmt->execute();
		$lesLignes = $stmt->fetchAll();
		return $lesLignes;
	}

    /**
     * Retourne tous les id de la table FraisForfait
     * @return array|false
     * return un tableau associatif
     */
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->execute();
		$lesLignes = $stmt->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 *
 * @param $idVisiteur
 * @param $mois * mois sous la forme aaaamm
 * @param $lesFrais * lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return void
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :unIdFrais";
			$stmt = $this->monPdo->prepare($req);
			$stmt->bindParam(':qte', $qte);
			$stmt->bindParam(':idVisiteur', $idVisiteur);
			$stmt->bindParam(':mois', $mois);
			$stmt->bindParam(':unIdFrais', $unIdFrais);
			$stmt->execute();
		}

	}

/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 *
 * @param $idVisiteur
 * @param $mois  * mois sous la forme aaaamm
 * @return bool
*/
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':mois', $mois);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->execute();
		$laLigne = $stmt->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param $idVisiteur
     * @return mixed return le mois sous la forme aaaamm
     */
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->execute();
		$laLigne = $stmt->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
     * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
     * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return void
     */
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		
		// Vérifier si un dernier mois existe avant de traiter la dernière fiche
		if ($dernierMois) {
			$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
			// Vérifier que la dernière fiche existe et a un état
			if ($laDerniereFiche && isset($laDerniereFiche['idEtat']) && $laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
			}
		}
		
		// Le reste du code reste inchangé
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat)
		values(:idVisiteur, :mois, 0, 0, now(), 'CR')";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->bindParam(':mois', $mois);
		$stmt->execute();
		
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur, mois, idFraisForfait, quantite)
			values(:idVisiteur, :mois, :unIdFrais, 0)";
			$stmt = $this->monPdo->prepare($req);
			$stmt->bindParam(':idVisiteur', $idVisiteur);
			$stmt->bindParam(':mois', $mois);
			$stmt->bindParam(':unIdFrais', $unIdFrais);
			$stmt->execute();
		}
	}


    /**
     * Retourne les mois pour lesquels un visiteur a une fiche de frais
     * @param $idVisiteur
     * @return array retourne un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
     * retourne un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
     */
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur = :idVisiteur
		order by fichefrais.mois desc ";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->execute();
		$lesMois =array();
		$laLigne = $stmt->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $stmt->fetch();
		}
		return $lesMois;
	}

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @return mixed return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état ou false si pas de fiche
     */
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		if (!$mois) return false; // Si pas de mois, retourner false directement
		
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs,
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from fichefrais inner join etat on fichefrais.idEtat = etat.id
			where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->bindParam(':mois', $mois);
		$stmt->execute();
		$laLigne = $stmt->fetch();
		return $laLigne ? $laLigne : false;
	}

    /**
     * Modifie l'état et la date de modification d'une fiche de frais
     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param $idVisiteur
     * @param $mois * mois sous la forme aaaamm
     * @param $etat
     * @return void
     */

	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = :etat, dateModif = now()
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':etat', $etat);
		$stmt->bindParam(':idVisiteur', $idVisiteur);
		$stmt->bindParam(':mois', $mois);
		$stmt->execute();
	}

    /**
     * Retourne tous les visiteurs sous forme d'un tableau associatif
     * @return array le tableau associatif des visiteurs
     */
    public function getLesVisiteurs(){
        $req = "select id, nom, prenom, adresse, cp, ville, dateEmbauche from visiteur order by dateEmbauche";
        $stmt = $this->monPdo->prepare($req);
        $stmt->execute();
        $lesVisiteurs = $stmt->fetchAll();
        return $lesVisiteurs;
    }

    /**
     * Retourne les informations d'un visiteur
     * @param $id identifiant du visiteur
     * @return mixed le tableau associatif des informations du visiteur
     */
    public function getUnVisiteur($id){
        $req = "select id, nom, prenom, login, adresse, cp, ville, dateEmbauche from visiteur where id = :id";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $leVisiteur = $stmt->fetch();
        return $leVisiteur;
    }

    /**
     * Modifie les informations d'un visiteur
     * @param $id identifiant du visiteur
     * @param $nom
     * @param $prenom
     * @param $login
     * @param $adresse
     * @param $cp
     * @param $ville
     * @param $dateEmbauche
     * @return int nombre de lignes affectées
     */
    public function majVisiteur($id, $nom, $prenom, $login, $adresse, $cp, $ville, $dateEmbauche){
        $req = "update visiteur set nom = :nom, prenom = :prenom, login = :login, 
                adresse = :adresse, cp = :cp, ville = :ville, dateEmbauche = :dateEmbauche
                where id = :id";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':dateEmbauche', $dateEmbauche);
        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * Ajoute un visiteur
     * @param $nom
     * @param $prenom
     * @param $adresse
     * @param $cp
     * @param $ville
     * @param $dateEmbauche
     * @return array tableau contenant l'identifiant, le login et le mot de passe du nouveau visiteur
     */
    public function ajouterVisiteur($nom, $prenom, $adresse, $cp, $ville, $dateEmbauche){
        // Génération d'un identifiant unique
        $id = 'v' . random_int(10, 99);
        
        // Génération du login (première lettre du prénom + nom, en minuscules)
        $premiereLettrePrenom = mb_substr(trim($prenom), 0, 1, 'UTF-8');
        $login = mb_strtolower($premiereLettrePrenom . trim($nom), 'UTF-8');
        
        // Remplacer les caractères spéciaux et espaces
        $login = preg_replace('/[^a-z0-9]/', '', $login);
        
        // S'assurer que le login est unique en ajoutant un nombre si nécessaire
        $loginBase = $login;
        $compteur = 1;
        
        while ($this->loginExiste($login)) {
            $login = $loginBase . $compteur;
            $compteur++;
        }
        
        // Génération d'un mot de passe aléatoire plus sécurisé (10 caractères avec majuscules, minuscules, chiffres et caractères spéciaux)
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?';
        $mdp_clair = substr(str_shuffle($chars), 0, 10);
        
        // Hachage du mot de passe avec bcrypt
        $mdp_hash = password_hash($mdp_clair, PASSWORD_DEFAULT);
        
        $req = "insert into visiteur(id, nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche) 
                values(:id, :nom, :prenom, :login, :mdp, :adresse, :cp, :ville, :dateEmbauche)";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':mdp', $mdp_hash);  // Stockage du hash, pas du mot de passe en clair
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':dateEmbauche', $dateEmbauche);
        $stmt->execute();
        
        // Retourner un tableau avec l'id, le login et le mot de passe en clair (pour l'afficher une seule fois à l'administrateur)
        return [
            'id' => $id,
            'login' => $login,
            'mdp' => $mdp_clair  // On renvoie le mot de passe en clair pour l'afficher à l'administrateur
        ];
    }

    /**
     * Vérifie si un login existe déjà
     * @param $login
     * @return bool true si le login existe, false sinon
     */
    public function loginExiste($login) {
        $req = "SELECT COUNT(*) FROM visiteur WHERE login = :login";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

}
