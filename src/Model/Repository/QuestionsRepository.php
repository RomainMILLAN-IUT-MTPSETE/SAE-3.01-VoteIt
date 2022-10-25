<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Question;

class QuestionsRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Questions";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Question($objetFormatTableau['idQuestion'], $objetFormatTableau['autheur'], $objetFormatTableau['titreQuestion'], $objetFormatTableau['texteQuestion'], $objetFormatTableau['ecritureDateDebut'], $objetFormatTableau['ecritureDateFin'], $objetFormatTableau['voteDateDebut'], $objetFormatTableau['voteDateFin']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idQuestion";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idQuestion',
            1 => 'autheur',
            2 => 'titreQuestion',
            3 => 'texteQuestion',
            4 => 'ecritureDateDebut',
            5 => 'ecritureDateFin',
            6 => 'voteDateDebut',
            7 => 'voteDateFin'];
    }
}