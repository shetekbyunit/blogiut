<?php

class utilisateurManager
{

    /**
     * 
     * @var PDO
     */
    private PDO $bdd;

    /**
     * 
     * @var bool|null
     */
    private ?bool $_result;

    /**
     * 
     * @var utilisateur
     */
    private utilisateur $_utilisateur;

    /**
     * 
     * @var int
     */
    private int $_getLastInsertId;

    /**
     * 
     * @return PDO
     */
    public function getBdd(): PDO
    {
        return $this->bdd;
    }

    /**
     * 
     * @return bool|null
     */
    public function get_result(): ?bool
    {
        return $this->_result;
    }

    /**
     * 
     * @return utilisateur
     */
    public function get_utilisateur(): utilisateur
    {
        return $this->_utilisateur;
    }

    /**
     * 
     * @return int
     */
    public function get_getLastInsertId(): int
    {
        return $this->_getLastInsertId;
    }

    /**
     * 
     * @param PDO $bdd
     * @return self
     */
    public function setBdd(PDO $bdd): self
    {
        $this->bdd = $bdd;
        return $this;
    }

    /**
     * 
     * @param bool|null $_result
     * @return self
     */
    public function set_result(?bool $_result): self
    {
        $this->_result = $_result;
        return $this;
    }

    /**
     * 
     * @param utilisateur $utilisateur
     * @return self
     */
    public function set_utilisateur(utilisateur $_utilisateur): self
    {
        $this->$_utilisateur = $_utilisateur;
        return $this;
    }

    /**
     * 
     * @param int $_getLastInsertId
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self
    {
        $this->_getLastInsertId = $_getLastInsertId;
        return $this;
    }

    /**
     * 
     * @param PDO $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->setBdd($bdd);
    }

    public function get(int $id)
    {

        //Prépare une requête de types SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM utilisateur WHERE id = :id';
        $req = $this->bdd->prepare($sql);
        //Execution de la requête avec l'attribution des valeurs aux marqueurs niminaux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateur = new utilisateur();
        $utilisateur->hydrate($donnees);
        return $utilisateur;
    }
    /**
     * 
     * @return array
     */
    public function getList(): array
    {
        $listutilisateur = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
            . 'nom, '
            . 'prenom, '
            . 'email, '
            . 'password'
            . 'FROM utilisateur';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $utilisateur = new utilisateur();
            $utilisateur->hydrate($donnees);
            $listUtilisateur[] = $utilisateur;
        }

        //print_r2($listArticle);
        return $listUtilisateur;
    }

   /**
     * 
     * @param string $email
     * @return utilisateur
     */
    public function getByEmail(string $email): utilisateur {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM utilisateur WHERE email = :email';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $utilisateur = new utilisateur();
        $utilisateur->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateur;
    }

/**
     * 
     * @param utilisateur $utilisateur
     * @return self
     */
    public function updateByEmail(utilisateur $utilisateur): self {
        $sql = "UPDATE utilisateur SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':sid', $utilisateur->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
        } else {
            $this->_result = false;
        }
        return $this;
    }
    /**
     * 
     * @param utilisateur $utilisateur
     * @return $this
     */
    public function add(utilisateur $utilisateur) {
        $sql = "INSERT INTO utilisateur "
                . "(nom, prenom, email, mdp) "
                . "VALUES (:nom, :prenom, :email, :mdp)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $utilisateur->getMdp(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

}
