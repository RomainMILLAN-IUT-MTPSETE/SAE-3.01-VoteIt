<?php
namespace App\VoteIt\Model\Repository;

class QuestionsRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Questions";
    }

    protected function construire(array $objetFormatTableau)
    {
        // TODO: Implement construire() method.
    }

    protected function getNomClePrimaire(): string
    {
        return "idQuestion";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idQuestion',
            1 => 'titreQuestion',
            2 => 'texteQuestion',
            3 => 'ecritureDateDebut',
            4 => 'ecritureDateFin',
            5 => 'voteDateDebut',
            6 => 'voteDateFin'];;
    }
}