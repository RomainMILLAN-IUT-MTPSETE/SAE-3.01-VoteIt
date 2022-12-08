<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;
use PDOException;

class QuestionsRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Questions";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Question($objetFormatTableau['idQuestion'], $objetFormatTableau['autheur'], $objetFormatTableau['titreQuestion'], $objetFormatTableau['ecritureDateDebut'], $objetFormatTableau['ecritureDateFin'], $objetFormatTableau['voteDateDebut'], $objetFormatTableau['voteDateFin'], $objetFormatTableau['categorieQuestion']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idQuestion";
    }

    protected function getNomsColonnes(): array
    {
        return [ 0 => 'idQuestion',
            1 => 'autheur',
            2 => 'titreQuestion',
            3 => 'ecritureDateDebut',
            4 => 'ecritureDateFin',
            5 => 'voteDateDebut',
            6 => 'voteDateFin',
            7 => 'categorieQuestion'];
    }

    public function recherche($search){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE titreQuestion LIKE '%".$search."%' OR categorieQuestion LIKE '%".$search."%' OR autheur LIKE '%".$search."%';";
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
        $query = "SELECT MAX(idQuestion) as idQuestion FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idQuestion'];

        if($resultat == null){
            $resultat = 1;
        }

        return $resultat;
    }

    public function createQuestion($idQuestion, $autheur, $titre, $ecritureDebut, $ecritureFin, $voteDebut, $voteFin, $categorie){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idQuestion, autheur, titreQuestion, ecritureDateDebut, ecritureDateFin, voteDateDebut, voteDateFin, categorieQuestion) VALUES(:idQuestion, :autheur, :titreQuestion, :ecritureDateDebut, :ecritureDateFin, :voteDateDebut, :voteDateFin, :categorieQuestion);";
        $pdoStatement = $pdo->prepare($query);

        $values = [
            'idQuestion' => $idQuestion,
            'autheur' => $autheur,
            'titreQuestion' => $titre,
            'ecritureDateDebut' => $ecritureDebut,
            'ecritureDateFin' => $ecritureFin,
            'voteDateDebut' => $voteDebut,
            'voteDateFin' => $voteFin,
            'categorieQuestion' => $categorie];

        $pdoStatement->execute($values);
    }

    public function updateQuestion(Question $question){
        try {
            $pdo = Model::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET autheur=:autheur, titreQuestion=:titreQuestion, ecritureDateDebut=:ecritureDateDebut, ecritureDateFin=:ecritureDateFin, voteDateDebut=:voteDateDebut, voteDateFin=:voteDateFin, categorieQuestion=:categorieQuestion WHERE idQuestion=:idQuestion";

            $pdoStatement = $pdo->prepare($sql);

            $values = [
                'idQuestion' => $question->getIdQuestion(),
                'autheur' => $question->getAutheur(),
                'titreQuestion' => $question->getTitreQuestion(),
                'ecritureDateDebut' => $question->getDateEcritureDebut(),
                'ecritureDateFin' => $question->getDateEcritureFin(),
                'voteDateDebut' => $question->getDateVoteDebut(),
                'voteDateFin' => $question->getDateVoteFin(),
                'categorieQuestion' => $question->getCategorieQuestion()];

            $pdoStatement->execute($values);

            return true;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }
    public function allIdQuestion(): ?array
    {
        try {
            $pdo = Model::getPdo();
            $sql = "SELECT " . $this->getNomClePrimaire() . " FROM " . $this->getNomTable();

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

}