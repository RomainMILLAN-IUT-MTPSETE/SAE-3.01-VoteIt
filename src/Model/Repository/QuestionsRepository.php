<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class QuestionsRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Questions";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Question($objetFormatTableau['idQuestion'], $objetFormatTableau['autheur'], $objetFormatTableau['titreQuestion'], $objetFormatTableau['texteQuestion'], $objetFormatTableau['planQuestion'], $objetFormatTableau['ecritureDateDebut'], $objetFormatTableau['ecritureDateFin'], $objetFormatTableau['voteDateDebut'], $objetFormatTableau['voteDateFin'], $objetFormatTableau['categorieQuestion']);
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
            3 => 'texteQuestion',
            4 => 'planQuestion',
            5 => 'ecritureDateDebut',
            6 => 'ecritureDateFin',
            7 => 'voteDateDebut',
            8 => 'voteDateFin',
            9 => 'categorieQuestion'];
    }

    public function recherche($search){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE titreQuestion LIKE '%".$search."%';";
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

        return $resultat;
    }

    public function createQuestion($autheur, $titre, $texte, $plan, $ecritureDebut, $ecritureFin, $voteDebut, $voteFin, $categorie){
        $pdo = Model::getPdo();
        $query = "INSERT INTO ".$this->getNomTable()."(idQuestion, autheur, titreQuestion, texteQuestion, planQuestion, ecritureDateDebut, ecritureDateFin, voteDateDebut, voteDateFin, categorieQuestion) VALUES(:idQuestion, :autheur, :titreQuestion, :texteQuestion, :planQuestion, :ecritureDateDebut, :ecritureDateFin, :voteDateDebut, :voteDateFin, :categorieQuestion);";
        $pdoStatement = $pdo->prepare($query);

        $idQuestion = ($this->getIdQuestionMax())+1;
        $values = [
            'idQuestion' => $idQuestion,
            'autheur' => $autheur,
            'titreQuestion' => $titre,
            'texteQuestion' => $texte,
            'planQuestion' => $plan,
            'ecritureDateDebut' => $ecritureDebut,
            'ecritureDateFin' => $ecritureFin,
            'voteDateDebut' => $voteDebut,
            'voteDateFin' => $voteFin,
            'categorieQuestion' => $categorie];

        $pdoStatement->execute($values);
    }

}