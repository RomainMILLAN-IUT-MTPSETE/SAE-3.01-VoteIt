<?php

namespace App\VoteIt\Model\DataObject;

class Reponse extends AbstractDataObject{
    private String $idReponse;
    private String $idQuestion;
    private String $autheurId;
    private String $texteReponse;
    private String $nbVote;

    /**
     * @param String $idReponse
     * @param String $idQuestion
     * @param String $texteReponse
     * @param String $nbVote
     */
    public function __construct(string $idReponse, string $idQuestion, string $autheurId, string $texteReponse, string $nbVote)
    {
        $this->idReponse = $idReponse;
        $this->idQuestion = $idQuestion;
        $this->autheurId = $autheurId;
        $this->texteReponse = $texteReponse;
        $this->nbVote = $nbVote;
    }


    public function formatTableau(): array{
        return array(
            "idReponse" => $this->getIdReponse(),
            "idQuestion" => $this->getIdQuestion(),
            "autheurId" => $this->getAutheurId(),
            "texteReponse" => $this->getTexteReponse(),
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
    public function getTexteReponse(): string
    {
        return $this->texteReponse;
    }

    /**
     * @param String $texteReponse
     */
    public function setTexteReponse(string $texteReponse): void
    {
        $this->texteReponse = $texteReponse;
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