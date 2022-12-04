<?php

class commentaireManager
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
     * @var commentaire
     */
    private commentaire $_commentaire;

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
     * @return commentaire
     */
    public function get_commentaire(): commentaire
    {
        return $this->_commentaire;
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
     * @param commentaire $commentaire
     * @return self
     */
    public function set_commentaire(commentaire $_commentaire): self
    {
        $this->$_commentaire = $_commentaire;
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
        $sql = 'SELECT * FROM commentaire WHERE id = :id';
        $req = $this->bdd->prepare($sql);
        //Execution de la requête avec l'attribution des valeurs aux marqueurs niminaux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $commentaire = new commentaire();
        $commentaire->hydrate($donnees);
        return $commentaire;
    }
    /**
     * 
     * @return array
     */
    public function getList(): array
    {
        $listcommentaire = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
            . 'com, '
            . 'pseudo, '
            . 'email, '
            . 'FROM commentaire';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $commentaire = new commentaire();
            $commentaire->hydrate($donnees);
            $listcommentaire[] = $commentaire;
        }

        //print_r2($listArticle);
        return $listcommentaire;
    }

   /**
     * 
     * @param string $email
     * @return commentaire
     */
    public function getByEmail(string $email): commentaire {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM commentaire WHERE email = :email';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        
        $donnees = !$donnees ? [] : $donnees;
        
        $commentaire = new commentaire();
        $commentaire->hydrate($donnees);
        return $commentaire;
    }

/**
     * 
     * @param commentaire $commentaire
     * @return self
     */
    public function updateByEmail(commentaire $commentaire): self {
        $sql = "UPDATE commentaire SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':email', $commentaire->getEmail(), PDO::PARAM_STR);
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
     * @param commentaire $commentaire
     * @return $this
     */
    public function add(commentaire $commentaire) {
        $sql = "INSERT INTO commentaire "
                . "(com, pseudo, email) "
                . "VALUES (:com, :pseudo, :email)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':nom', $commentaire->getCom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $commentaire->getPseudo(), PDO::PARAM_STR);
        $req->bindValue(':email', $commentaire->getEmail(), PDO::PARAM_STR);
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
