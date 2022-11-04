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
        return new Question($objetFormatTableau['idQuestion'], $objetFormatTableau['autheur'], $objetFormatTableau['titreQuestion'], $objetFormatTableau['texteQuestion'], $objetFormatTableau['planQuestion'], $objetFormatTableau['ecritureDateDebut'], $objetFormatTableau['ecritureDateFin'], $objetFormatTableau['voteDateDebut'], $objetFormatTableau['voteDateFin'], $objetFormatTableau['categorieQuestion']);
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
            4 => 'planQuestion',
            5 => 'ecritureDateDebut',
            6 => 'ecritureDateFin',
            7 => 'voteDateDebut',
            8 => 'voteDateFin',
            9 => 'categorieQuestion'];
    }

}