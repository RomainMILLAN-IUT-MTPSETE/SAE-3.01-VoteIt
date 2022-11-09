<?php

namespace App\VoteIt\Model\DataObject;

class Categorie extends AbstractDataObject{
    private String $nomCategorie;

    /**
     * @param String $nomCategorie
     */
    public function __construct(string $nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;
    }


    public function formatTableau(): array
    {
        return array(
            "nomCategorie" => $this->getNomCategorie(),
        );
    }



    /**
     * @return String
     */
    public function getNomCategorie(): string
    {
        return $this->nomCategorie;
    }

    /**
     * @param String $nomCategorie
     */
    public function setNomCategorie(string $nomCategorie): void
    {
        $this->nomCategorie = $nomCategorie;
    }


}