<?php

namespace App\VoteIt\Model\DataObject;

class Reponse extends AbstractDataObject
{
    private string $idReponse;
    private string $idQuestion;
    private string $titreReponse;
    private string $autheurId;
    private bool $estVisible;

    /**
     * @param string $idReponse
     * @param string $idQuestion
     * @param string $titreReponse
     * @param string $autheurId
     * @param bool $estVisible
     */
    public function __construct(string $idReponse, string $idQuestion, string $titreReponse, string $autheurId, bool $estVisible)
    {
        $this->idReponse = $idReponse;
        $this->idQuestion = $idQuestion;
        $this->titreReponse = $titreReponse;
        $this->autheurId = $autheurId;
        $this->estVisible = $estVisible;
    }

    public function formatTableau(): array
    {
        return array(
            "idReponse" => $this->getIdReponse(),
            "idQuestion" => $this->getIdQuestion(),
            "titreReponse" => $this->getTitreReponse(),
            "autheurId" => $this->getAutheurId(),
            "estVisible" => $this->isEstVisible(),
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
     * @return bool
     */
    public function isEstVisible(): bool
    {
        return $this->estVisible;
    }




}