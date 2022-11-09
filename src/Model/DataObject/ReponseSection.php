<?php

namespace App\VoteIt\Model\DataObject;

class ReponseSection extends AbstractDataObject{
    private String $idSection;
    private String $idReponse;
    private String $texteSection;

    /**
     * @param String $idSection
     * @param String $idReponse
     * @param String $texteSection
     */
    public function __construct(string $idSection, string $idReponse, string $texteSection)
    {
        $this->idSection = $idSection;
        $this->idReponse = $idReponse;
        $this->texteSection = $texteSection;
    }


    public function formatTableau(): array
    {
        return array(
            "idSection" => $this->getIdSection(),
            "idReponse" => $this->getIdReponse(),
            "texteSection" => $this->getTexteSection(),
        );
    }



    //GETTER SETTER

    /**
     * @return String
     */
    public function getIdSection(): string
    {
        return $this->idSection;
    }

    /**
     * @param String $idSection
     */
    public function setIdSection(string $idSection): void
    {
        $this->idSection = $idSection;
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
    public function getTexteSection(): string
    {
        return $this->texteSection;
    }

    /**
     * @param String $texteSection
     */
    public function setTexteSection(string $texteSection): void
    {
        $this->texteSection = $texteSection;
    }



}