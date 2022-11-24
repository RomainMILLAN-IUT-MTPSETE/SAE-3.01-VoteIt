<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\Repository\DatabaseConnection as Model;
use App\VoteIt\Model\DataObject\Reponse;

class VoteRepository{
    protected function getNomTable(): string
    {
        return "vit_Vote";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Vote($objetFormatTableau['idQuestion'], $objetFormatTableau['idReponse'], $objetFormatTableau['idUtilisateur']);
    }

    public function stateVote($idQuestion, $idUtilisateur): bool{
        $pdo = Model::getPdo();
        $sql = " SELECT COUNT(*) as nbVote FROM " .  static::getNomTable() . " WHERE idQuestion=:idQuestion AND idUtilisateur=:idUtilisateur";
        // Préparation de la requête
        $pdoStatement = $pdo->prepare($sql);


        $values = array(
            "idQuestion" => $idQuestion,
            "idUtilisateur" => $idUtilisateur
        );

        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['nbVote'];
        $res = true;

        if($resultat >= 1){
            $res = false;
        }

        return $res;
    }

    public function vote($reponse){
        //USERCHANGE
        if($this->stateVote($reponse->getIdQuestion(), "nadalc")){
            $pdo = Model::getPdo();
            $query = "INSERT INTO ".$this->getNomTable()."(idQuestion, idReponse, idUtilisateur) VALUES(:idQuestion, :idReponse, :idUtilisateur);";
            $pdoStatement = $pdo->prepare($query);

            //CHANGEUSER
            $values = [
                'idQuestion' => $reponse->getIdQuestion(),
                'idReponse' => $reponse->getIdReponse(),
                'idUtilisateur' => "nadalc"];

            $pdoStatement->execute($values);

            (new ReponsesRepository())->update(new Reponse($reponse->getIdReponse(), $reponse->getIdQuestion(), $reponse->getTitreReponse(), $reponse->getAutheurId(), $reponse->getNbVote()+1));
        }
    }
}