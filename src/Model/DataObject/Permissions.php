<?php

namespace App\VoteIt\Model\DataObject;

class Permissions extends AbstractDataObject{
    private String $idQuestion;
    private String $idReponse;
    private String $idUtilisateur;

    /**
     * @param String $idQuestion
     * @param String $idReponse
     * @param String $idUtilisateur
     */
    public function __construct(string $idQuestion, string $idReponse, string $idUtilisateur)
    {
        $this->idQuestion = $idQuestion;
        $this->idReponse = $idReponse;
        $this->idUtilisateur = $idUtilisateur;
    }


    public function formatTableau(): array
    {
        return array(
          "idQuestion" => $this->getIdQuestion(),
          "idReponse" => $this->getIdReponse(),
          "idUtilisateur" => $this->getIdUtilisateur(),
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
    public function getIdUtilisateur(): string
    {
        return $this->idUtilisateur;
    }

    /**
     * @param String $idUtilisateur
     */
    public function setIdUtilisateur(string $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }



}