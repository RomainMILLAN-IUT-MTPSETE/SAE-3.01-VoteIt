<?php
namespace App\VoteIt\Model\DataObject;

class Question extends AbstractDataObject {
    private String $idQuestion;
    private String $autheur;
    private String $titreQuestion;
    private String $texteQuestion;
    private String $dateEcritureDebut;
    private String $dateEcritureFin;
    private String $dateVoteDebut;
    private String $dateVoteFin;
    private String $categorieQuestion;

    /**
     * @param String $idQuestion
     * @param String $titreQuestion
     * @param String $texteQuestion
     * @param String $dateEcritureDebut
     * @param String $dateEcritureFin
     * @param String $dateVoteDebut
     * @param String $dateVoteFin
     */
    public function __construct(string $idQuestion, string $autheur, string $titreQuestion, string $texteQuestion, string $dateEcritureDebut, string $dateEcritureFin, string $dateVoteDebut, string $dateVoteFin, string $categorieQuestion)
    {
        $this->idQuestion = $idQuestion;
        $this->autheur = $autheur;
        $this->titreQuestion = $titreQuestion;
        $this->texteQuestion = $texteQuestion;
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
    public function getTexteQuestion(): string
    {
        return $this->texteQuestion;
    }

    /**
     * @param String $texteQuestion
     */
    public function setTexteQuestion(string $texteQuestion): void
    {
        $this->texteQuestion = $texteQuestion;
    }

    /**
     * @return String
     */
    public function getDateEcritureDebut(): string
    {
        return $this->dateEcritureDebut;
    }

    /**
     * @param String $dateEcritureDebut
     */
    public function setDateEcritureDebut(string $dateEcritureDebut): void
    {
        $this->dateEcritureDebut = $dateEcritureDebut;
    }

    /**
     * @return String
     */
    public function getDateEcritureFin(): string
    {
        return $this->dateEcritureFin;
    }

    /**
     * @param String $dateEcritureFin
     */
    public function setDateEcritureFin(string $dateEcritureFin): void
    {
        $this->dateEcritureFin = $dateEcritureFin;
    }

    /**
     * @return String
     */
    public function getDateVoteDebut(): string
    {
        return $this->dateVoteDebut;
    }

    /**
     * @param String $dateVoteDebut
     */
    public function setDateVoteDebut(string $dateVoteDebut): void
    {
        $this->dateVoteDebut = $dateVoteDebut;
    }

    /**
     * @return String
     */
    public function getDateVoteFin(): string
    {
        return $this->dateVoteFin;
    }

    /**
     * @param String $dateVoteFin
     */
    public function setDateVoteFin(string $dateVoteFin): void
    {
        $this->dateVoteFin = $dateVoteFin;
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






    //GETTER SETTERS

}