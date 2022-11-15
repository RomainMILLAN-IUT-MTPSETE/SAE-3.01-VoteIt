<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class SectionRepository{
    protected function getNomTable(): string
    {
        return "vit_Section";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Section($objetFormatTableau['idSection'], $objetFormatTableau['idQuestion'], $objetFormatTableau['titreSection'], $objetFormatTableau['descriptionSection']);
    }

    public function selectAllByIdQuestion($idQuestion){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idQuestion='".$idQuestion."';";
        $pdoStatement = $pdo->query($query);

        $tab = [];

        foreach ($pdoStatement as $tableauSelecter) {

            $tab[] = $this->construire($tableauSelecter);

        }

        return $tab;
    }

    /**
     * Retourne l'id de question maximum
     * @return mixed
     */
    public function getIdQuestionMax(): int{
        $pdo = Model::getPdo();
        $query = "SELECT MAX(idSection) as idSection FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idSection'];

        return $resultat;
    }

    public function createSection($section){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idSection, idQuestion, titreSection, descriptionSection) VALUES(:idSection, :idQuestion, :titreSection, :descriptionSection);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idSection' => $section->getIdSection(),
            'idQuestion' => $section->getIdQuestion(),
            'titreSection' => $section->getTitreSection(),
            'descriptionSection' => $section->getDescriptionSection()];

        $pdoStatement->execute($values);
    }

}