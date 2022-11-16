<?php
namespace App\VoteIt\Model\DataObject;

class Question extends AbstractDataObject {
    private String $idQuestion;
    private String $autheur;
    private String $titreQuestion;
    private String $dateEcritureDebut;
    private String $dateEcritureFin;
    private String $dateVoteDebut;
    private String $dateVoteFin;
    private String $categorieQuestion;

    /**
     * @param String $idQuestion
     * @param String $titreQuestion
     * @param String $dateEcritureDebut
     * @param String $dateEcritureFin
     * @param String $dateVoteDebut
     * @param String $dateVoteFin
     */
    public function __construct(string $idQuestion, string $autheur, string $titreQuestion, string $dateEcritureDebut, string $dateEcritureFin, string $dateVoteDebut, string $dateVoteFin, string $categorieQuestion)
    {
        $this->idQuestion = $idQuestion;
        $this->autheur = $autheur;
        $this->titreQuestion = $titreQuestion;
        $this->dateEcritureDebut = $dateEcritureDebut;
        $this->dateEcritureFin = $dateEcritureFin;
        $this->dateVoteDebut = $dateVoteDebut;
        $this->dateVoteFin = $dateVoteFin;
        $this->categorieQuestion = $categorieQuestion;
    }


    public function formatTableau(): array
    {
        return array(
            "idQuestion" => $this->getIdQuestion(),
            "autheur" => $this->getAutheur(),
            "titreQuestion" => $this->getTitreQuestion(),
            "dateEcritureDebut" => $this->getDateEcritureDebut(),
            "dateEcritureFin" => $this->getDateEcritureFin(),
            "dateVoteDebut" => $this->getDateVoteDebut(),
            "dateVoteFin" => $this->getDateVoteFin(),
            "categorieQuestion" => $this->getCategorieQuestion(),
        );
    }

    //GETTER SETTERS
    /**
     * @return String
     */
    public function getIdQuestion(): string
    {
        return $this->idQuestion;
    }

    /**
     * @param String $idQuestion
     */
    public function setIdQuestion(string $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return String
     */
    public function getAutheur(): string
    {
        return $this->autheur;
    }

    /**
     * @param String $autheur
     */
    public function setAutheur(string $autheur): void
    {
        $this->autheur = $autheur;
    }

    /**
     * @return String
     */
    public function getTitreQuestion(): string
    {
        return $this->titreQuestion;
    }

    /**
     * @param String $titreQuestion
     */
    public function setTitreQuestion(string $titreQuestion): void
    {
        $this->titreQuestion = $titreQuestion;
    }

    /**
     * @return String
     */
    public function getDateEcritureDebut(): string
    {
        return $this->dateEcritureDebut;
    }

    /**
     * @return String
     */
    public function getDateEcritureFin(): string
    {
        return $this->dateEcritureFin;
    }

    /**
     * @return String
     */
    public function getDateVoteDebut(): string
    {
        return $this->dateVoteDebut;
    }

    /**
     * @return String
     */
    public function getDateVoteFin(): string
    {
        return $this->dateVoteFin;
    }

    /**
     * @return String
     */
    public function getCategorieQuestion(): string
    {
        return $this->categorieQuestion;
    }

    /**
     * @param String $categorieQuestion
     */
    public function setCategorieQuestion(string $categorieQuestion): void
    {
        $this->categorieQuestion = $categorieQuestion;
    }

    public function getDateEcritureDebutFR(){
        return date('d/m/Y', strtotime($this->dateEcritureDebut));
    }
    public function getDateEcritureFinFR(){
        return date('d/m/Y', strtotime($this->dateEcritureFin));
    }
    public function getDateVoteDebutFR(){
        return date('d/m/Y', strtotime($this->dateVoteDebut));
    }
    public function getDateVoteFinFR(){
        return date('d/m/Y', strtotime($this->dateVoteFin));
    }


}