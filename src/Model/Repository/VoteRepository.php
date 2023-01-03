<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Lib\ConnexionUtilisateur;
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

    /**
     * Retourne le status de vote pour une question et un utilisateur | True= peut voter | False= ne peut pas voter
     * @param $idQuestion
     * @param $idUtilisateur
     * @return bool
     */
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

    /**
     * Permet de voter pour l'utilisateur courant
     * @param $reponse
     * @return void
     */
    public function vote($reponse, $vote){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idQuestion, idReponse, idUtilisateur, vote) VALUES(:idQuestion, :idReponse, :idUtilisateur, :vote);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idQuestion' => $reponse->getIdQuestion(),
            'idReponse' => $reponse->getIdReponse(),
            'idUtilisateur' => ConnexionUtilisateur::getLoginUtilisateurConnecte(),
            'vote' => $vote];

        $pdoStatement->execute($values);

        //TO TEST: (new ReponsesRepository())->update(new Reponse($reponse->getIdReponse(), $reponse->getIdQuestion(), $reponse->getTitreReponse(), $reponse->getAutheurId()));
    }

    /**
     * Retourne le nombre de vote pour une réponse
     * @param $idReponse
     * @return mixed
     */
    public static function getNbVoteForReponse($idReponse){
        $pdo = Model::getPdo();
        $sql = " SELECT COUNT(*) as nbVote FROM " .  (new VoteRepository())->getNomTable() . " WHERE idReponse=:idReponse";
        // Préparation de la requête
        $pdoStatement = $pdo->prepare($sql);


        $values = array(
            "idReponse" => $idReponse
        );

        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['nbVote'];

        return $resultat;
    }

    /**
     * Retourne le nombre de réponse par une identifiant de question
     * @param $idQuestion
     * @return float|int
     */
    public function getNbVoteForQuestion($idQuestion){
        $pdo = Model::getPdo();
        $sql = "SELECT COUNT(*) as nbVote FROM " . self::getNomTable() . " WHERE idQuestion=:idQuestion";
        $pdoStatement = $pdo->prepare($sql);

        $values = array(
            "idQuestion" => $idQuestion
        );

        $pdoStatement->execute($values);
        $resultatSQL = $pdoStatement->fetch();
        $nbReponse = (new ReponsesRepository())->getNbReponseForQuestion($idQuestion);

        $res = $resultatSQL['nbVote'] / $nbReponse;
        return $res;
    }
}