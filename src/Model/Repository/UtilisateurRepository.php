<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Utilisateur";
    }

    protected function construire(array $objetFormatTableau): Utilisateur{
        return new Utilisateur($objetFormatTableau['idUtilisateur'], $objetFormatTableau['nomUtilisateur'], $objetFormatTableau['prenomUtilisateur'], $objetFormatTableau['dateNaissanceUtilisateur'], $objetFormatTableau['iconeLink'], $objetFormatTableau['mailUtilisateur'], $objetFormatTableau['gradeUtilisateur']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idUtilisateur";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idUtilisateur',
            1 => 'nomUtilisateur',
            2 => 'prenomUtilisateur',
            3 => 'dateNaissanceUtilisateur',
            4 => 'iconeLink',
            5 => 'mailUtilisateur',
            6 => 'gradeUtilisateur'];
    }
}
