<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;
use PDOException;

class QuestionsRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "vit_Questions";
    }

    protected function construire(array $objetFormatTableau)
    {
        if ($objetFormatTableau['estVisible'] == 1) {
            $estVisible = true;
        } else {
            $estVisible = false;
        }

        if ($objetFormatTableau['estProposer'] == 1) {
            $estProposer = true;
        } else {
            $estProposer = false;
        }

        return new Question($objetFormatTableau['idQuestion'], $objetFormatTableau['autheur'], $objetFormatTableau['titreQuestion'], $objetFormatTableau['ecritureDateDebut'], $objetFormatTableau['ecritureDateFin'], $objetFormatTableau['voteDateDebut'], $objetFormatTableau['voteDateFin'], $objetFormatTableau['categorieQuestion'], $estVisible, $estProposer);
    }

    protected function getNomClePrimaire(): string
    {
        return "idQuestion";
    }

    protected function getNomsColonnes(): array
    {
        return [0 => 'idQuestion',
            1 => 'autheur',
            2 => 'titreQuestion',
            3 => 'ecritureDateDebut',
            4 => 'ecritureDateFin',
            5 => 'voteDateDebut',
            6 => 'voteDateFin',
            7 => 'categorieQuestion',
            10 => 'estVisible',
            11 => 'estProposer'];
    }

    /**
     * Permet d'avoir une liste d'identifiant de question pour la fonction de recherche
     * @param $search
     * @return array
     */
    public function recherche($search): array
    {
        $pdo = Model::getPdo();
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE titreQuestion LIKE '%" . $search . "%' OR categorieQuestion LIKE '%" . $search . "%' OR autheur LIKE '%" . $search . "%' AND estProposer='0';";
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
    public function getIdQuestionMax(): int
    {
        $pdo = Model::getPdo();
        $query = "SELECT MAX(idQuestion) as idQuestion FROM " . $this->getNomTable() . ";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idQuestion'];

        if ($resultat == null) {
            $resultat = 1;
        }

        return $resultat;
    }

    /**
     * Crée une question dans la BDD
     * @param $idQuestion
     * @param $autheur
     * @param $titre
     * @param $ecritureDebut
     * @param $ecritureFin
     * @param $voteDebut
     * @param $voteFin
     * @param $categorie
     * @param $estVisible
     * @param $estProposer
     * @return void
     */
    public function createQuestion($idQuestion, $autheur, $titre, $ecritureDebut, $ecritureFin, $voteDebut, $voteFin, $categorie, $estVisible, $estProposer)
    {
        $pdo = Model::getPdo();
        $query = "INSERT INTO " . $this->getNomTable() . "(idQuestion, autheur, titreQuestion, ecritureDateDebut, ecritureDateFin, voteDateDebut, voteDateFin, categorieQuestion, estVisible, estProposer) VALUES(:idQuestion, :autheur, :titreQuestion, :ecritureDateDebut, :ecritureDateFin, :voteDateDebut, :voteDateFin, :categorieQuestion, :estVisible, :estProposer);";
        $pdoStatement = $pdo->prepare($query);

        if ($estVisible == true) {
            $estVisible = 1;
        } else {
            $estVisible = 0;
        }

        $values = [
            'idQuestion' => $idQuestion,
            'autheur' => $autheur,
            'titreQuestion' => $titre,
            'ecritureDateDebut' => $ecritureDebut,
            'ecritureDateFin' => $ecritureFin,
            'voteDateDebut' => $voteDebut,
            'voteDateFin' => $voteFin,
            'categorieQuestion' => $categorie,
            'estVisible' => $estVisible,
            'estProposer' => $estProposer];

        $pdoStatement->execute($values);
    }

    /**
     * Permet d'update une question
     * @param Question $question
     * @return bool
     */
    public function updateQuestion(Question $question)
    {
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET autheur=:autheur, titreQuestion=:titreQuestion, ecritureDateDebut=:ecritureDateDebut, ecritureDateFin=:ecritureDateFin, voteDateDebut=:voteDateDebut, voteDateFin=:voteDateFin, categorieQuestion=:categorieQuestion, estVisible=:estVisible, estProposer=:estProposer WHERE idQuestion=:idQuestion";

            $pdoStatement = $pdo->prepare($sql);

            if ($question->isEstVisible() == true) {
                $estVisible = 1;
            } else {
                $estVisible = 0;
            }

            if ($question->isEstProposer() == true) {
                $estProposer = 1;
            } else {
                $estProposer = 0;
            }

            $values = [
                'idQuestion' => $question->getIdQuestion(),
                'autheur' => $question->getAutheur(),
                'titreQuestion' => $question->getTitreQuestion(),
                'ecritureDateDebut' => $question->getDateEcritureDebut(),
                'ecritureDateFin' => $question->getDateEcritureFin(),
                'voteDateDebut' => $question->getDateVoteDebut(),
                'voteDateFin' => $question->getDateVoteFin(),
                'categorieQuestion' => $question->getCategorieQuestion(),
                'estVisible' => $estVisible,
                'estProposer' => $estProposer];

            $pdoStatement->execute($values);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * Retourne une liste d'identifiant de question étant visible et qui ne sont pas en cour de proposition
     * @return array
     */
    public function selectAllQuestionVisible()
    {
        $pdo = Model::getPdo();
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE estVisible=1 AND estProposer=0;";
        $pdoStatement = $pdo->query($query);
        $tab = [];
        foreach ($pdoStatement as $tableauSelecter) {
            $tab[] = $this->construire($tableauSelecter);
        }
        return $tab;

    }

    /**
     * Retourne une liste d'identifiant de question étant invisible et qui ne sont pas en cour de proposition
     * @return array
     */
    public function getAllIdQuestionNonVisible()
    {
        $pdo = Model::getPdo();
        $query = "SELECT idQuestion FROM " . $this->getNomTable() . " WHERE estVisible=0 AND estProposer=0;";
        $pdoStatement = $pdo->query($query);
        $tab = [];
        foreach ($pdoStatement as $tableauSelecter) {
            $tab[] = $tableauSelecter['idQuestion'];
        }
        return $tab;

    }

    /**
     * Retourne la liste de tous les identifiants de question par ordre
     * @return array|null
     */
    public function allIdQuestion(): ?array
    {
        try {
            $pdo = Model::getPdo();
            $sql = "SELECT " . $this->getNomClePrimaire() . " FROM " . $this->getNomTable() . " ORDER BY " . $this->getNomClePrimaire();

            $pdoStatement = $pdo->query($sql);

            $tab = [];

            foreach ($pdoStatement as $tableauSelecter) {
                $tab[] = $tableauSelecter[0];
            }

            return $tab;

        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }
    }

    /**
     * Update une question en non visible
     * @param $idQuestion
     * @return bool
     */
    public function setNonVisibleByIdQuestion($idQuestion)
    {
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET estVisible=0 WHERE idQuestion=:idQuestion";

            $pdoStatement = $pdo->prepare($sql);

            $values = [
                'idQuestion' => $idQuestion];

            $pdoStatement->execute($values);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    //DASHBOARD
    /**
     * Retourne le nombre de question active
     * @return int
     */
    public function countNbQuestionActive(): int
    {
        $pdo = Model::getPdo();
        $query = "SELECT COUNT(idQuestion) as nbQuestion FROM " . $this->getNomTable() . " WHERE estVisible=1;";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['nbQuestion'];

        if ($resultat == null) {
            $resultat = 0;
        }

        return $resultat;
    }

    /**
     * Retourne une liste contenant tous les ids de question à vérifier par les administrateurs
     * @return array|null
     */
    public function getAllIdQuestionToProposer(): ?array
    {
        try {
            $pdo = Model::getPdo();
            $sql = "SELECT " . $this->getNomClePrimaire() . " FROM " . $this->getNomTable() . " WHERE estProposer=1 ORDER BY " . $this->getNomClePrimaire();

            $pdoStatement = $pdo->query($sql);

            $tab = [];

            foreach ($pdoStatement as $tableauSelecter) {
                $tab[] = $tableauSelecter[0];
            }

            return $tab;

        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }
    }

}