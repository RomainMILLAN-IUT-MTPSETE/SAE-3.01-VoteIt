<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Section;

class SectionRepository{
    protected function getNomTable(): string
    {
        return "vit_Section";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Section($objetFormatTableau['idSection'], $objetFormatTableau['idQuestion'], $objetFormatTableau['titreSection']);
    }

}