<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class SectionRepository{
    protected function getNomTable(): string
    {
        return "vit_Section";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Section($objetFormatTableau['idSection'], $objetFormatTableau['idQuestion'], $objetFormatTableau['titreSection']);
    }

    public function selectAllByIdQuestion($idQuestion){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idQuestion='".$idQuestion."';";
        $pdoStatement = $pdo->query($query);

        $tab = [];

        foreach ($pdoStatement as $tableauSelecter) {

            $tab[] = $this->construire($tableauSelecter);

        }

        return $tab;
    }

}