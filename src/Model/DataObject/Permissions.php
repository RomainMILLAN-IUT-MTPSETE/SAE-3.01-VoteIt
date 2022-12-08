<?php

namespace App\VoteIt\Model\DataObject;

class Permissions extends AbstractDataObject{
    private String $idPermission;
    private String $idUtilisateur;
    private String $idQuestion;
    private String $idReponse;
    private String $permission;

    /**
     * @param String $idPermission
     * @param String $idUtilisateur
     * @param String $idQuestion
     * @param String $idReponse
     * @param String $permission
     */
    public function __construct(string $idPermission, string $idUtilisateur, string $idQuestion, string $idReponse, string $permission)
    {
        $this->idPermission = $idPermission;
        $this->idUtilisateur = $idUtilisateur;
        $this->idQuestion = $idQuestion;
        $this->idReponse = $idReponse;
        $this->permission = $permission;
    }


    public function formatTableau(): array
    {
        return array(
            "idPermission" => $this->getIdPermission(),
            "idUtilisateur" => $this->getIdUtilisateur(),
            "idQuestion" => $this->getIdQuestion(),
            "idReponse" => $this->getIdReponse(),
            "permission" => $this->getPermission()
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

    /**
     * @return String
     */
    public function getIdPermission(): string
    {
        return $this->idPermission;
    }

    /**
     * @param String $idPermission
     */
    public function setIdPermission(string $idPermission): void
    {
        $this->idPermission = $idPermission;
    }

    /**
     * @return String
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @param String $permission
     */
    public function setPermission(string $permission): void
    {
        $this->permission = $permission;
    }





}