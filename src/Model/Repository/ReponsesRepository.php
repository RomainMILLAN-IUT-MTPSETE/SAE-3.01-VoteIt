<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\Repository\DatabaseConnection as Model;
use App\VoteIt\Model\DataObject\Reponse;

class ReponsesRepository extends AbstractRepository{
    protected function getNomTable(): string
    {
        return "vit_Reponses";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Reponse($objetFormatTableau['idReponse'], $objetFormatTableau['idQuestion'], $objetFormatTableau['titreReponse'], $objetFormatTableau['autheurId'], $objetFormatTableau['nbVote']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idReponse";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idReponse',
            1 => 'idQuestion',
            2 => 'titreReponse',
            3 => 'autheurId',
            4 => 'nbVote'];
    }


    /**
     * Selectionner toutes les réponse d'une question
     * @param String $idQuestion
     * @return array
     */
    public function selectAllReponeByQuestionId(String $idQuestion){
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
     * Retourne l'id de reponse maximum
     * @return mixed
     */
    public function getIdReponseMax(): int{
        $pdo = Model::getPdo();
        $query = "SELECT MAX(idReponse) as idReponse FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idReponse'];

        if($resultat==null){
            $resultat=0;
        }

        return $resultat;
    }

    /**
     * Create reponse pour une question
     * @return void
     */
    public function createReponse(Reponse $reponse){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idReponse, idQuestion, titreReponse, autheurId, nbVote) VALUES(:idReponse, :idQuestion, :titreReponse, :autheurId, :nbVote);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idReponse' => $reponse->getIdReponse(),
            'idQuestion' => $reponse->getIdQuestion(),
            'titreReponse' => $reponse->getTitreReponse(),
            'autheurId' => $reponse->getAutheurId(),
            'nbVote' => $reponse->getNbVote()];

        $pdoStatement->execute($values);
    }
}