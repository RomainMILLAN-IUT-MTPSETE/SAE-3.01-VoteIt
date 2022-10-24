<?php

class Utilisateur {
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
}
