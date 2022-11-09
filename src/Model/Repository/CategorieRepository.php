<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Categorie;

class CategorieRepository extends AbstractRepository {


    protected function getNomTable(): string
    {
        return "vit_Categorie";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Categorie($objetFormatTableau['nomCategorie']);
    }

    protected function getNomClePrimaire(): string
    {
        return "nomCategorie";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'nomCategorie'];
    }
}