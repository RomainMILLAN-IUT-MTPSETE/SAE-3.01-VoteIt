<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\ReponseSection;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class ReponseSectionRepository{

    protected function getNomTable(): string
    {
        return "vit_Reponse_Section";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new ReponseSection($objetFormatTableau['idQuestion'], $objetFormatTableau['idReponse'], $objetFormatTableau['idUtilisateur']);
    }

    public function selectAllByIdReponse($idReponse){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idReponse=:idReponse;";
        $pdoStatement = $pdo->query($query);

        $tab = [];

        foreach ($pdoStatement as $tableauSelecter) {

            $tab[] = $this->construire($tableauSelecter);

        }

        return $tab;

    }
}