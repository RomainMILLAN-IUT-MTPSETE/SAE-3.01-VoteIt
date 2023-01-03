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

        $nbReponse > 0 ? $res = $resultatSQL['nbVote'] / $nbReponse : $res = 0;
        return $res;
    }

    public function getIdReponseGagnante($idQuestion){
        $pdo = Model::getPdo();
        $query = "SELECT vote FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion
        );

        $pdoStatement->execute($values);


        $resVote = [];
        $allIdReponseForQuestion = (new ReponsesRepository())->selectAllReponeByQuestionId($idQuestion);
        foreach ($allIdReponseForQuestion as $reponse) {
            $resVote[$reponse->getIdReponse()] = $this->getVoteListeForIdReponseAndIdQuestion($idQuestion, $reponse->getIdReponse());
        }

        $nbVote = $this->getNbVoteForQuestion($idQuestion);

        if($nbVote == 0){
            $idReponseGagnante[] = -1;
            return $idReponseGagnante;
        }

        if($nbVote%2 == 0){
            //PAIR
            $mediane = $nbVote/2 -1;
        }else {
            //IMPAIR
            $mediane = $nbVote/2;
        }

        $voteMax = -1;
        $idReponseGagnante = [];

        foreach($allIdReponseForQuestion as $item){
            if($resVote[$item->getIdReponse()][$mediane] > $voteMax){
                unset($idReponseGagnante);
                $voteMax = $resVote[$item->getIdReponse()][$mediane];
                $idReponseGagnante[] = $item->getIdReponse();
            }else if($resVote[$item->getIdReponse()][$mediane] >= $voteMax){
                $voteMax = $resVote[$item->getIdReponse()][$mediane];
                $idReponseGagnante[] = $item->getIdReponse();
            }
        }


        while(count($idReponseGagnante) > 1 && $mediane <= $nbVote && $mediane > 0 ){
            foreach ($allIdReponseForQuestion as $reponse){
                $list = [];

                $indice = 0;
                for($i=0; $i<$nbVote; $i++){
                    if($i != $mediane){
                        $list[$indice] = $resVote[$reponse->getIdReponse()][$indice];
                        $indice++;
                    }
                }

                unset($resVote[$reponse->getIdReponse()]);
                $resVote[$reponse->getIdReponse()] = $list;
            }
            $nbVote--;



            if($nbVote > 0){
                $nbVote--;
            }
            if($nbVote < 2){
                $mediane = 0;
            }else if($nbVote%2 == 0){
                //PAIR
                $mediane = $nbVote/2 - 1;
            }else {
                //IMPAIR
                $mediane = ($nbVote/2);
            }

            $voteMax = -1;
            var_dump($resVote);
            foreach($allIdReponseForQuestion as $item){
                if($resVote[$item->getIdReponse()][$mediane] > $voteMax){
                    unset($idReponseGagnante);
                    $voteMax = $resVote[$item->getIdReponse()][$mediane];
                    $idReponseGagnante[] = $item->getIdReponse();
                }else if($resVote[$item->getIdReponse()][$mediane] == $voteMax){
                    $idReponseGagnante[] = $item->getIdReponse();
                }
            }
            echo("<br/><br/>");
            var_dump($idReponseGagnante);
        }


        return $idReponseGagnante;
    }

    public function getVoteListeForIdReponseAndIdQuestion($idQuestion, $idReponse){
        $pdo = Model::getPdo();
        $query = "SELECT vote FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion AND idReponse=:idReponse ORDER BY vote ASC";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion,
            "idReponse" => $idReponse
        );

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $item) {
            $res[] = $item['vote'];
        }

        return $res;
    }
}