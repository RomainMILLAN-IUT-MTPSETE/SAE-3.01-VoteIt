<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Permissions;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class PermissionsRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Permissions";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Permissions($objetFormatTableau['idPermission'], $objetFormatTableau['idUtilisateur'], $objetFormatTableau['idQuestion'], $objetFormatTableau['idReponse'], $objetFormatTableau['permission']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idPermission";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idPermission',
            1 => 'idUtilisateur',
            2 => 'idQuestion',
            3 => 'idReponse',
            4 => 'permission'];
    }

    public function selectAllPermissionsByIdUtilisateur($idUtilisateur){
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idUtilisateur=:idUtilisateur;";
        $pdoStatement = Model::getPdo()->prepare($query);

        $values = array(
            "idUtilisateur" => $idUtilisateur,
        );

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $tableauSelecter) {

            $res[] = $this->construire($tableauSelecter);

        }

        return $res;
    }
}