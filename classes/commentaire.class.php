<?php
class commentaire {

    /**
     * 
     * @var int
     */
    public ?int $id;

    /**
     * 
     * @var string
     */
    public string $com;

    /**
     * 
     * @var string
     */
    public string $pseudo;

    /**
     * 
     * @var string
     */
    public string $email;
    /**
     * 
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }
    
    /**
     * 
     * @return string
     */
    public function getCom(): string {
        return $this->com;
    }

    /**
     * 
     * @return string
     */
    public function getPseudo(): string {
        return $this->pseudo;
    }

    /**
     * 
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * 
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param string $com
     * @return self
     */
    public function setCom(string $com): self {
        $this->com = $com;
        return $this;
    }

    /**
     * 
     * @param string $pseudo
     * @return self
     */
    public function setPseudo(string $pseudo): self {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * 
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * 
     * @param array $donnees
     * @return self
     */
    public function hydrate(array $donnees): self {

        if (!empty($donnees['id'])) {
            $this->setId($donnees['id']);
        } else {
            $this->setId(null);
        }

        if (!empty($donnees['com'])) {
            $this->setCom($donnees['com']);
        } else {
            $this->setCom('');
        }

        if (!empty($donnees['pseudo'])) {
            $this->setPseudo($donnees['pseudo']);
        } else {
            $this->setPseudo('');
        }

        if (!empty($donnees['email'])) {
            $this->setEmail($donnees['email']);
        } else {
            $this->setEmail('');
        }
        return $this;
    }

}
