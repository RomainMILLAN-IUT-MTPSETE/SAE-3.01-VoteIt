<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\ReponseSection;

class ReponseSectionRepository{

    protected function getNomTable(): string
    {
        return "vit_Reponse_Section";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new ReponseSection($objetFormatTableau['idQuestion'], $objetFormatTableau['idReponse'], $objetFormatTableau['idUtilisateur']);
    }
}