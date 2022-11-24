<?php

namespace App\VoteIt\Model\DataObject;

class Vote {
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


}