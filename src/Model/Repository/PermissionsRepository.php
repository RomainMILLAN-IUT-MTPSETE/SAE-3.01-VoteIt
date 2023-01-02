<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Permissions;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class PermissionsRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "vit_Permissions";
    }

    protected function construire(array $objetFormatTableau)
    {
        return new Permissions($objetFormatTableau['idPermission'], $objetFormatTableau['idUtilisateur'], $objetFormatTableau['idQuestion'], $objetFormatTableau['idReponse'], $objetFormatTableau['permission']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idPermission";
    }

    protected function getNomsColonnes(): array
    {
        return [0 => 'idPermission',
            1 => 'idUtilisateur',
            2 => 'idQuestion',
            3 => 'idReponse',
            4 => 'permission'];
    }

    /**
     * Retourne l'id de reponse maximum
     * @return mixed
     */
    public function getIdMaxPermission(): int
    {
        $pdo = Model::getPdo();
        $query = "SELECT MAX(idPermission) as idPermission FROM " . $this->getNomTable() . ";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idPermission'];

        if ($resultat == null) {
            $resultat = 0;
        }

        return $resultat;
    }

    /**
     * Peret de rajouter une persmission en fonction d'un IdUtilisateur d'un idQuestion et d'une permission pour une question
     * @param string $idUtilisateur
     * @param int $idQuestion
     * @param string $permission
     * @return void
     */
    public function addQuestionPermission(string $idUtilisateur, int $idQuestion, string $permission): void
    {
        try {
            $pdo = Model::getPdo();
            $sql = "INSERT INTO " . $this->getNomTable() . "(`idPermission`, `idUtilisateur`, `idQuestion`, `idReponse`, `permission`) VALUES (:idPermission, :idUtilisateur, :idQuestion, :idReponse, :permission);";

            $pdoStatement = $pdo->prepare($sql);

            $values = array(
                "idPermission" => $this->getIdMaxPermission() + 1,
                "idUtilisateur" => $idUtilisateur,
                "idQuestion" => $idQuestion,
                "idReponse" => -1,
                "permission" => $permission
            );
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Permet de rajouter une permission à une réponse
     * @param string $idUtilisateur
     * @param int $idReponse
     * @param string $permission
     * @return void
     */
    public function addReponsePermission(string $idUtilisateur, int $idReponse, string $permission): void
    {
        try {
            $pdo = Model::getPdo();
            $sql = "INSERT INTO " . $this->getNomTable() . "(`idPermission`, `idUtilisateur`, `idQuestion`, `idReponse`, `permission`) VALUES (:idPermission, :idUtilisateur, :idQuestion, :idReponse, :permission);";

            $pdoStatement = $pdo->prepare($sql);

            $values = array(
                "idPermission" => $this->getIdMaxPermission() + 1,
                "idUtilisateur" => $idUtilisateur,
                "idQuestion" => -1,
                "idReponse" => $idReponse,
                "permission" => $permission
            );
            $pdoStatement->execute($values);

        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Permet de savoir si l'utilisateur est un responsable de proposition sur une question
     * @param $idQuestion
     * @param $idUtilisateur
     * @return bool
     */
    public function getPermissionReponsableDePropositionParIdUtilisateurEtIdQuestion($idQuestion, $idUtilisateur): bool
    {
        $pdo = Model::getPdo();
        $query = "SELECT permission FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion AND idUtilisateur=:idUtilisateur AND idReponse=-1 AND permission='ResponsableDeProposition';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion,
            "idUtilisateur" => $idUtilisateur);

        $pdoStatement->execute($values);

        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permet de savoir si un utilisateur est un votant ou non
     * @param $idQuestion
     * @param $idUtilisateur
     * @return bool
     */
    public function getPermissionVotantParIdUtilisateurEtIdQuestion($idQuestion, $idUtilisateur): bool
    {
        $pdo = Model::getPdo();
        $query = "SELECT permission FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion AND idUtilisateur=:idUtilisateur AND idReponse=-1 AND permission='Votant';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion,
            "idUtilisateur" => $idUtilisateur);

        $pdoStatement->execute($values);

        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permet de savoir si un utilisateur est un co-auteur d'une réponse
     * @param $idReponse
     * @param $idUtilisateur
     * @return bool
     */
    public function getPermissionCoAuteurParIdUtilisateurEtIdReponse($idReponse, $idUtilisateur): bool
    {
        $pdo = Model::getPdo();
        $query = "SELECT permission FROM " . $this->getNomTable() . " WHERE idReponse=:idReponse AND idUtilisateur=:idUtilisateur AND idQuestion=-1 AND permission='CoAuteur';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idReponse" => $idReponse,
            "idUtilisateur" => $idUtilisateur);

        $pdoStatement->execute($values);

        if ($pdoStatement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Permet d'avoir une liste de permission des utilisateurs ayant des permission par rapport à une idQuestion
     * @param $idQuestion
     * @return array
     */
    public function getListePermissionResponsableParQuestion($idQuestion)
    {
        $pdo = Model::getPdo();
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion AND permission='ResponsableDeProposition';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion);

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $item) {
            $res[] = $this->construire($item);
        }

        return $res;
    }

    /**
     * Permet d'avoir une liste de votant par rapport à une question
     * @param $idQuestion
     * @return array
     */
    public function getListePermissionVotantParQuestion($idQuestion)
    {
        $pdo = Model::getPdo();
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion AND permission='Votant';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion);

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $item) {
            $res[] = $this->construire($item);
        }

        return $res;
    }

    /**
     * Permet d'avoir une liste d'utilisateur étant coauteur pour une réponse
     * @param $idReponse
     * @return array
     */
    public function getListePermissionCoAuteurParReponse($idReponse)
    {
        $pdo = Model::getPdo();
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE idReponse=:idReponse AND permission='CoAuteur';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idReponse" => $idReponse);

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $item) {
            $res[] = $this->construire($item);
        }

        return $res;
    }


    /**
     * Supprimer toutes les permissions pour une question
     * @param $idQuestion
     * @return void
     */
    public function deleteAllPermissionForIdQuestion($idQuestion): void
    {
        $pdo = Model::getPdo();
        $query = "DELETE FROM " . $this->getNomTable() . " WHERE idQuestion=:idQuestion;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion);

        $pdoStatement->execute($values);
    }

    /**
     * Supprimer toutes les permissions pour une réponse
     * @param $idReponse
     * @return void
     */
    public function deleteAllPermissionForIdReponse($idReponse): void
    {
        $pdo = Model::getPdo();
        $query = "DELETE FROM " . $this->getNomTable() . " WHERE idReponse=:idReponse;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idReponse" => $idReponse);

        $pdoStatement->execute($values);
    }





    /*A RECHERCHER SI UTILISER*/
    /*public function selectAllPermissionsByIdUtilisateur($idUtilisateur)
    {
        $query = "SELECT * FROM " . $this->getNomTable() . " WHERE idUtilisateur=:idUtilisateur;";
        $pdoStatement = Model::getPdo()->prepare($query);

        $values = array(
            "idUtilisateur" => $idUtilisateur,
        );

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $tableauSelecter) {

            $res[] = $this->construire($tableauSelecter);

        }

        return $res;
    }*/
}