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
        return new ReponseSection($objetFormatTableau['idSection'], $objetFormatTableau['idReponse'], $objetFormatTableau['texteSection']);
    }

    /**
     * Selectionner toutes les sections au réponse par l'id de réponse
     * @param $idReponse
     * @return array
     */
    public function selectAllByIdReponse($idReponse){
        $sql = " SELECT * FROM " .  static::getNomTable() . " WHERE idReponse=:idReponse";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "idReponse" => $idReponse,
            //nomdutag => valeur, ...
        );

        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        $tab = [];
        foreach ($pdoStatement as $tableauSelecter) {

            $tab[] = $this->construire($tableauSelecter);

        }

        return $tab;
    }


    /**
     * Creation de Section à une réponse par un object ReponseSection
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

    /**
     * Supprime les reponses secitons qui on l'identifiant reponse
     * @param $idreponse
     * @return void
     */
    public function deleteReponseSectionByIdReponse($idreponse) {
        $sql = " DELETE FROM " .  static::getNomTable() . " WHERE idReponse=:idReponse";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);
        $values = array(
            "idReponse" => $idreponse,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
    }

    /**
     * Mets à jour une réponse section
     * @param ReponseSection $reponseSection
     * @return bool
     */
    public function updateReponseSection(ReponseSection $reponseSection){
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET texteSection=:texteSection WHERE idReponse=:idReponse AND idSection=:idSection";

            $pdoStatement = $pdo->prepare($sql);

            $values = array(
                "texteSection" => $reponseSection->getTexteSection(),
                "idReponse" => $reponseSection->getIdReponse(),
                "idSection" => $reponseSection->getIdSection()
                //nomdutag => valeur, ...
            );
            $pdoStatement->execute($values);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }
}