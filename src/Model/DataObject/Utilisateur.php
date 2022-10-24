<?php
namespace App\VoteIt\Model\DataObject;

class Utilisateur extends AbstractDataObject {
    private String $identifiant;
    private String $nom;
    private String $prenom;
    private String $dateNaissance;
    private String $mail;
    private String $iconeLink;
    private String $grade;

    /**
     * @param String $identifiant
     * @param String $nom
     * @param String $prenom
     * @param String $dateNaissance
     * @param String $mail
     * @param String $iconeLink
     * @param String $grade
     */
    public function __construct(string $identifiant, string $nom, string $prenom, string $dateNaissance, string $mail, string $iconeLink, string $grade)
    {
        $this->identifiant = $identifiant;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->mail = $mail;
        $this->iconeLink = $iconeLink;
        $this->grade = $grade;
    }

    public function formatTableau(): array
    {
        {
            return array(
                "identifiant" => $this->getIdentifiant(),
                "nom" => $this->getNom(),
                "prenom" => $this->getPrenom(),
                "dateNaissance" => $this->getDateNaissance(),
                "mail" => $this->getMail(),
                "iconeLink" => $this->getIconeLink(),
                "grade" => $this->getGrade(),
            );
        }
    }

    /**
     * @return String
     */
    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    /**
     * @param String $identifiant
     */
    public function setIdentifiant(string $identifiant): void
    {
        $this->identifiant = $identifiant;
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param String $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return String
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param String $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return String
     */
    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    /**
     * @param String $dateNaissance
     */
    public function setDateNaissance(string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return String
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param String $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return String
     */
    public function getIconeLink(): string
    {
        return $this->iconeLink;
    }

    /**
     * @param String $iconeLink
     */
    public function setIconeLink(string $iconeLink): void
    {
        $this->iconeLink = $iconeLink;
    }

    /**
     * @return String
     */
    public function getGrade(): string
    {
        return $this->grade;
    }

    /**
     * @param String $grade
     */
    public function setGrade(string $grade): void
    {
        $this->grade = $grade;
    }


    //GETTER & SETTER

}
