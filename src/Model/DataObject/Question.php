<?php

namespace App\VoteIt\Model\DataObject;

class Question extends AbstractDataObject
{
    private string $idQuestion;
    private string $autheur;
    private string $titreQuestion;
    private string $dateEcritureDebut;
    private string $dateEcritureFin;
    private string $dateVoteDebut;
    private string $dateVoteFin;
    private string $categorieQuestion;
    private bool $estVisible;
    private bool $estProposer;

    /**
     * @param String $idQuestion
     * @param String $autheur
     * @param String $titreQuestion
     * @param String $dateEcritureDebut
     * @param String $dateEcritureFin
     * @param String $dateVoteDebut
     * @param String $dateVoteFin
     * @param String $categorieQuestion
     * @param bool $estVisible
     * @param bool $estProposer
     */
    public function __construct(string $idQuestion, string $autheur, string $titreQuestion, string $dateEcritureDebut, string $dateEcritureFin, string $dateVoteDebut, string $dateVoteFin, string $categorieQuestion, bool $estVisible, bool $estProposer)
    {
        $this->idQuestion = $idQuestion;
        $this->autheur = $autheur;
        $this->titreQuestion = $titreQuestion;
        $this->dateEcritureDebut = $dateEcritureDebut;
        $this->dateEcritureFin = $dateEcritureFin;
        $this->dateVoteDebut = $dateVoteDebut;
        $this->dateVoteFin = $dateVoteFin;
        $this->categorieQuestion = $categorieQuestion;
        $this->estVisible = $estVisible;
        $this->estProposer = $estProposer;
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
            "estVisible" => $this->isEstVisible(),
            "estProposer" => $this->isEstProposer(),
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

    /**
     * @return bool
     */
    public function isEstVisible(): bool
    {
        return $this->estVisible;
    }

    /**
     * @param bool $estVisible
     */
    public function setEstVisible(bool $estVisible): void
    {
        $this->estVisible = $estVisible;
    }

    /**
     * @return bool
     */
    public function isEstProposer(): bool
    {
        return $this->estProposer;
    }

    /**
     * @param bool $estProposer
     */
    public function setEstProposer(bool $estProposer): void
    {
        $this->estProposer = $estProposer;
    }


    public function getDateEcritureDebutFR()
    {
        return date_format(date_create($this->dateEcritureDebut), 'd/m/Y');
    }

    public function getDateEcritureFinFR()
    {
        return date_format(date_create($this->dateEcritureFin), 'd/m/Y');
    }

    public function getDateVoteDebutFR()
    {
        return date_format(date_create($this->dateVoteDebut), 'd/m/Y');
    }

    public function getDateVoteFinFR()
    {
        return date_format(date_create($this->dateVoteFin), 'd/m/Y');
    }


}