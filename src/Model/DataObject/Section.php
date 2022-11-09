<?php

namespace App\VoteIt\Model\DataObject;

use App\VoteIt\Model\Repository\AbstractRepository;

class Section extends AbstractDataObject {
    private String $idSection;
    private String $idQuestion;
    private String $titreSection;

    /**
     * @param String $idSection
     * @param String $idQuestion
     * @param String $titreSection
     */
    public function __construct(string $idSection, string $idQuestion, string $titreSection)
    {
        $this->idSection = $idSection;
        $this->idQuestion = $idQuestion;
        $this->titreSection = $titreSection;
    }

    public function formatTableau(): array{
        return array(
            "idSection" => $this->getIdSection(),
            "idQuestion" => $this->getIdQuestion(),
            "titreSection" => $this->getTitreSection(),
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
    public function getTitreSection(): string
    {
        return $this->titreSection;
    }

    /**
     * @param String $titreSection
     */
    public function setTitreSection(string $titreSection): void
    {
        $this->titreSection = $titreSection;
    }





}