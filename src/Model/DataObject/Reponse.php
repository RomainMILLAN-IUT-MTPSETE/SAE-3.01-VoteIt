<?php

namespace App\VoteIt\Model\DataObject;

class Reponse extends AbstractDataObject{
    private String $idReponse;
    private String $idQuestion;
    private String $titreReponse;
    private String $autheurId;
    private String $nbVote;

    /**
     * @param String $idReponse
     * @param String $idQuestion
     * @param String $nbVote
     */
    public function __construct(string $idReponse, string $idQuestion, string $titreReponse, string $autheurId, string $nbVote)
    {
        $this->idReponse = $idReponse;
        $this->idQuestion = $idQuestion;
        $this->titreReponse = $titreReponse;
        $this->autheurId = $autheurId;
        $this->nbVote = $nbVote;
    }


    public function formatTableau(): array{
        return array(
            "idReponse" => $this->getIdReponse(),
            "idQuestion" => $this->getIdQuestion(),
            "titreReponse" => $this->getTitreReponse(),
            "autheurId" => $this->getAutheurId(),
            "nbVote" => $this->getNbVote(),
        );
    }




    //GETTER AND SETTER

    /**
     * @return String
     */
    public function getAutheurId(): string
    {
        return $this->autheurId;
    }

    /**
     * @param String $autheurId
     */
    public function setAutheurId(string $autheurId): void
    {
        $this->autheurId = $autheurId;
    }

    /**
     * @return String
     */
    public function getIdReponse(): string
    {
        return $this->idReponse;
    }

    /**
     * @param String $idReponse
     */
    public function setIdReponse(string $idReponse): void
    {
        $this->idReponse = $idReponse;
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
    public function getTitreReponse(): string
    {
        return $this->titreReponse;
    }

    /**
     * @param String $texteReponse
     */
    public function setTitreReponse(string $titreReponse): void
    {
        $this->titreReponse = $titreReponse;
    }

    /**
     * @return String
     */
    public function getNbVote(): string
    {
        return $this->nbVote;
    }

    /**
     * @param String $nbVote
     */
    public function setNbVote(string $nbVote): void
    {
        $this->nbVote = $nbVote;
    }





}