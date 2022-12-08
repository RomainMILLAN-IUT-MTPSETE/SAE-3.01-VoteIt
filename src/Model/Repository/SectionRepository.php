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

        if($resultat == null){
            $resultat = 1;
        }

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

    public function  selectFromIdSection($idSection){

        $sql = " SELECT * FROM " .  static::getNomTable() . " WHERE idSection=:idSection";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "idSection" => $idSection,
        );
        $pdoStatement->execute($values);

        $ressultatSQL = $pdoStatement->fetch();

        if (!$ressultatSQL) {
            $res = null;
        } else {
            $res = static::construire($ressultatSQL);
        }

        return $res;

    }

    public function deleteSectionByIdQuestion($idQuestion) {
        $sql = " DELETE FROM " .  static::getNomTable() . " WHERE idQuestion=:idQuestion";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);
        $values = array(
            "idQuestion" => $idQuestion,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
    }

    public function updateSectionByIdQuestion(Section $section) {
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . static::getNomTable() . " SET idQuestion=:idQuestion, titreSection=:titreSection, descriptionSection=:descriptionSection WHERE idSection=:idSection";
            $pdoStatement = $pdo->prepare($sql);
            $values = [
                'idSection' => $section->getIdSection(),
                'idQuestion' => $section->getIdQuestion(),
                'titreSection' => $section->getTitreSection(),
                'descriptionSection' => $section->getDescriptionSection()];

            $pdoStatement->execute($values);

            return true;
        }catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public function updateSectionByIdSection(Section $section) {
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . static::getNomTable() . " SET titreSection=:titreSection, descriptionSection=:descriptionSection WHERE idSection=:idSection";
            $pdoStatement = $pdo->prepare($sql);

            $values = [
                'titreSection' => $section->getTitreSection(),
                'descriptionSection' => $section->getDescriptionSection(),
                'idSection' => $section->getIdSection()];

            $pdoStatement->execute($values);

            return true;
        }catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

}