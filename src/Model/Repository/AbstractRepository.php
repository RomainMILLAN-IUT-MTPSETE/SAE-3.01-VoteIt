<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\AbstractDataObject;
use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\DataObject\Voiture;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

abstract class AbstractRepository{

    public function selectAll(){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $tab = [];
        foreach ($pdoStatement as $tableauSelecter) {
            $tab[] = $this->construire($tableauSelecter);
        }
        return $tab;

    }

    public function select(string $valuePrimaire){

        $sql = " SELECT * FROM " .  static::getNomTable() . " WHERE " .  static::getNomClePrimaire() . "=:valuePrimaire";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "valuePrimaire" => $valuePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas de voiture correspondante
        $ressultatSQL = $pdoStatement->fetch();

        if (!$ressultatSQL) {

            $res = null;

        } else {

            $res = static::construire($ressultatSQL);

        }

        return $res;

    }

    public function delete($valeurClePrimaire) {
        $sql = " DELETE FROM " .  static::getNomTable() . " WHERE " .  static::getNomClePrimaire() . "=:cleprm";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);
        $values = array(
            "cleprm" => $valeurClePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
    }

    public function update(AbstractDataObject $obj){
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET ";

            foreach ($this->getNomsColonnes() as $str) {
                if(strcmp($str, $this->getNomClePrimaire()) !== 0){
                    $sql = $sql.$str . " = :" . $str . " , ";
                }
            }

            $sql = rtrim($sql,' , ');

            $sql = $sql." WHERE " . $this->getNomClePrimaire() . " = :" . $this->getNomClePrimaire() . "; ";
            $pdoStatement = $pdo->prepare($sql);

            $arrayList = $obj->formatTableau();
            $pdoStatement->execute($arrayList);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public function create(AbstractDataObject $obj){
        try {
            $pdo = Model::getPdo();
            $sql = "INSERT INTO " . $this->getNomTable() . "(";

            foreach ($this->getNomsColonnes() as $str) {
                $sql = $sql . "`" . $str . "`, ";
            }
            $sql = rtrim($sql,' , ');

            $sql = $sql.") VALUES(";

            foreach ($this->getNomsColonnes() as $str) {
                $sql = $sql . ":" . $str . ", ";
            }
            $sql = rtrim($sql,' , ');

            $sql = $sql."); ";

            $pdoStatement = $pdo->prepare($sql);
            $arrayList = $obj->formatTableau();
            $pdoStatement->execute($arrayList);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    protected abstract function getNomTable(): string;
    protected abstract function construire(array $objetFormatTableau);
    protected abstract function getNomClePrimaire(): string;
    protected abstract function getNomsColonnes(): array;
}