<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\Repository\DatabaseConnection as Model;
use App\VoteIt\Model\DataObject\Reponse;

class ReponsesRepository extends AbstractRepository{
    protected function getNomTable(): string
    {
        return "vit_Reponses";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Reponse($objetFormatTableau['idReponse'], $objetFormatTableau['idQuestion'], $objetFormatTableau['autheurId'], $objetFormatTableau['texteReponse'], $objetFormatTableau['nbVote']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idReponse";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idReponse',
            1 => 'idQuestion',
            2 => 'autheurId',
            3 => 'texteReponse',
            4 => 'nbVote'];
    }

    public function selectAllReponeByQuestionId(String $idQuestion){
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