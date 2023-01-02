<?php

namespace App\VoteIt\Model\DataObject;

class Vote extends AbstractDataObject {
    private int $idQuestion;
    private int $idReponse;
    private String $idUtilisateur;

    /**
     * @param int $idQuestion
     * @param int $idReponse
     * @param String $idUtilisateur
     */
    public function __construct(int $idQuestion, int $idReponse, string $idUtilisateur)
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





    //GETTER & SETTER
    /**
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * @param int $idQuestion
     */
    public function setIdQuestion(int $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return int
     */
    public function getIdReponse(): int
    {
        return $this->idReponse;
    }

    /**
     * @param int $idReponse
     */
    public function setIdReponse(int $idReponse): void
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