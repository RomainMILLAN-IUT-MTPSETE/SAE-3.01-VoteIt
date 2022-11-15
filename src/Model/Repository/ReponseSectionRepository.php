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

    /**
     * Selectionner toutes les sections au réponse par l'id de réponse;
     * @param $idReponse
     * @return array
     */
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


    /**
     * Creation de Section à une réponse par un object ReponseSection;
     * @param $ReponseSection
     */
    public function createReponseSection(ReponseSection $ReponseSection){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idSection, idReponse, texteSection) VALUES(:idSection, :idReponse, :texteSection);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idSection' => $ReponseSection->getIdSection(),
            'idReponse' => $ReponseSection->getIdReponse(),
            'texteSection' => $ReponseSection->getTexteSection()];

        $pdoStatement->execute($values);

    }
}