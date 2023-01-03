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
        $objetFormatTableau['estVisible'] == 1 ? $estVisible = true : $estVisible = false;
        return new Reponse($objetFormatTableau['idReponse'], $objetFormatTableau['idQuestion'], $objetFormatTableau['titreReponse'], $objetFormatTableau['autheurId'], $estVisible);
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
            4 => 'estVisible'];
    }


    /**
     * Selectionner toutes les réponses d'une question
     * @param String $idQuestion
     * @return array
     */
    public function selectAllReponeByQuestionIdWhereIsVisible(String $idQuestion){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idQuestion='".$idQuestion."' AND estVisible=1;";
        $pdoStatement = $pdo->query($query);

        $tab = [];

        foreach ($pdoStatement as $tableauSelecter) {

            $tab[] = $this->construire($tableauSelecter);

        }

        return $tab;

    }

    /**
     * Selectionner une reponse par l'idReponse
     * @param String $idQuestion
     * @return array
     */
    public function selectReponseByIdReponse(String $idReponse){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idReponse='".$idReponse."';";
        $pdoStatement = $pdo->query($query);

        $ressultatSQL = $pdoStatement->fetch();

        if (!$ressultatSQL) {
            $res = null;
        } else {
            $res = static::construire($ressultatSQL);
        }

        return $res;
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
        $query = "INSERT INTO ".$this->getNomTable()."(idReponse, idQuestion, titreReponse, autheurId, estVisible) VALUES(:idReponse, :idQuestion, :titreReponse, :autheurId, :estVisible);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idReponse' => $reponse->getIdReponse(),
            'idQuestion' => $reponse->getIdQuestion(),
            'titreReponse' => $reponse->getTitreReponse(),
            'autheurId' => $reponse->getAutheurId(),
            'estVisible' => 1];

        $pdoStatement->execute($values);
    }

    /**
     * Suppressions de reponse par identifiant (Passage de estVisible sur false)
     * @param $idReponse
     * @return void
     */
    public function deleteReponseByIdReponse($idReponse): void {
        //(new ReponseSectionRepository())->deleteReponseSectionByIdReponse($idReponse);
        $sql = "UPDATE " .  static::getNomTable() . " SET estVisible=0 WHERE idReponse=:idReponse";

        $pdoStatement = Model::getPdo()->prepare($sql);
        $values = array(
            "idReponse" => $idReponse,
        );

        $pdoStatement->execute($values);
    }

    /**
     * Tous les identifiants de reponse de question
     * @param $idQuestion
     * @return array|null
     */
    public function allIdReponseByIdQuestion($idQuestion): ?array
    {
        try {
            $pdo = Model::getPdo();
            $sql = "SELECT " . $this->getNomClePrimaire() . " FROM " . $this->getNomTable() . " WHERE idQuestion='" . $idQuestion . "' ORDER BY " . $this->getNomClePrimaire();

            $pdoStatement = $pdo->query($sql);

            $tab = [];

            foreach ($pdoStatement as $tableauSelecter) {
                $tab[] = $tableauSelecter[0];
            }

            return $tab;

        }catch (PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }
    }

    /**
     * Retourne le nombre de vote maximum d'une reponse à une question
     * @param $idQuestion
     * @return int|mixed
     */
    public function getNbVoteMax($idQuestion): int{
        $pdo = Model::getPdo();
        $sql = "SELECT idReponse, COUNT(idReponse) as nbVote FROM vit_Vote WHERE idQuestion=:idQuestion GROUP BY idReponse";

        $pdoStatement = $pdo->prepare($sql);

        $values = [
            'idQuestion' => $idQuestion];

        $pdoStatement->execute($values);



        $nbVote = [];
        foreach ($pdoStatement as $tableauSelecter) {
            $nbVote[] = array($tableauSelecter[0], $tableauSelecter[1]);
        }

        $nbVoteMax = -1;
        foreach ($nbVote as $item){
            if($item[1] > $nbVoteMax){
                $nbVoteMax = $item[1];
            }
        }

        return $nbVoteMax;
    }

    /**
     * Retourne l'identifiant reponse avec le maximum de vote pour une question
     * @param $idQuestion
     * @return array
     */
    public function getIdReponseWithVoteMaxParIdQuestion($idQuestion): array{
        $pdo = Model::getPdo();
        $sql = "SELECT idReponse, COUNT(idReponse) as nbVote FROM vit_Vote WHERE idQuestion=:idQuestion GROUP BY idReponse";
        $pdoStatement = $pdo->prepare($sql);
        $values = [
            'idQuestion' => $idQuestion];
        $pdoStatement->execute($values);



        $idReponseEtNbVote = [];
        foreach ($pdoStatement as $tableauSelecter) {
            $idReponseEtNbVote[] = array($tableauSelecter[0], $tableauSelecter[1]);
        }

        $nbVoteMax = $this->getNbVoteMax($idQuestion);

        $res = [];
        foreach ($idReponseEtNbVote as $item){
            if($item[1] == $nbVoteMax){
                $res[] = $item[0];
            }
        }


        return $res;
    }

    /**
     * Retourne le nombre de réponse pour 1 question
     * @param $idQuestion
     * @return mixed
     */
    public function getNbReponseForQuestion($idQuestion){
        $pdo = Model::getPdo();
        $sql = "SELECT COUNT(idReponse) as nbReponse FROM " . self::getNomTable() . " WHERE idQuestion=:idQuestion";

        $pdoStatement = $pdo->prepare($sql);

        $values = [
            'idQuestion' => $idQuestion];

        $pdoStatement->execute($values);


        $resultatSQL = $pdoStatement->fetch();
        return $resultatSQL['nbReponse'];
    }



    //A VERIFIER SI UTILISER
    /*public function deleteReponseByIdQuestion($idQuestion) {
        $reponseIds = (new ReponsesRepository())->selectReponseByIdReponse($idQuestion);
        foreach ($reponseIds as $item){
            (new ReponseSectionRepository())->deleteReponseSectionByIdReponse($item);
        }

        $sql = " DELETE FROM " .  static::getNomTable() . " WHERE idQuestion=:idQuestion";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);
        $values = array(
            "idQuestion" => $idQuestion,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
    }*/
    /*public function updateQuestionById($reponse){
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET idReponse=:idReponse, titreReponse=:titreReponse, autheur=:autheur WHERE idQuestion=:idQuestion";

            $pdoStatement = $pdo->prepare($sql);

            $values = [
                'idQuestion' => $reponse->getIdQuestion(),
                'titreQuestion' => $reponse->getTitreReponse(),
                'autheur' => $reponse->getAutheurId(),
                'idReponse' => $reponse->getAutheurId()];

            $pdoStatement->execute($values);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }*/
}