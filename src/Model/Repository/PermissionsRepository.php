<?php

namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Permissions;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class PermissionsRepository extends AbstractRepository {

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
        return [ 0 => 'idPermission',
            1 => 'idUtilisateur',
            2 => 'idQuestion',
            3 => 'idReponse',
            4 => 'permission'];
    }

    public function selectAllPermissionsByIdUtilisateur($idUtilisateur){
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idUtilisateur=:idUtilisateur;";
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
    }

	/**
	* Retourne l'id de reponse maximum
	* @return mixed
	*/
	public function getIdMaxPermission(): int{
        $pdo = Model::getPdo();
        $query = "SELECT MAX(idPermission) as idPermission FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['idPermission'];

        if($resultat==null){
            $resultat=0;
        }

		return $resultat;
    }


	public function addQuestionPermission(string $idUtilisateur, int $idQuestion, string $permission): void{
        try {
            $pdo = Model::getPdo();
            $sql = "INSERT INTO " . $this->getNomTable() . "(`idPermission`, `idUtilisateur`, `idQuestion`, `idReponse`, `permission`) VALUES (:idPermission, :idUtilisateur, :idQuestion, :idReponse, :permission);";

            $pdoStatement = $pdo->prepare($sql);

            $values = array(
                    "idPermission" => $this->getIdMaxPermission()+1,
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

	public function addReponsePermission(string $idUtilisateur, int $idReponse, string $permission): void{
	        try {
	            $pdo = Model::getPdo();
	            $sql = "INSERT INTO " . $this->getNomTable() . "(`idPermission`, `idUtilisateur`, `idQuestion`, `idReponse`, `permission`) VALUES (:idPermission, :idUtilisateur, :idQuestion, :idReponse, :permission);";

	            $pdoStatement = $pdo->prepare($sql);

	            $values = array(
                    "idPermission" => $this->getIdMaxPermission()+1,
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

	public function getPermissionQuestionParIdUtilisateur($idQuestion, $idUtilisateur): string{
        $pdo = Model::getPdo();
        $query = "SELECT permission FROM ".$this->getNomTable()." WHERE idQuestion=:idQuestion AND idUtilisateur=:idUtilisateur AND idReponse='-1';";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
                "idQuestion" => $idQuestion,
				"idUtilisateur" => $idUtilisateur);

        $pdoStatement->execute($values);

        if($pdoStatement->rowCount() > 0){
            $resultatSQL = $pdoStatement->fetch();

            $resultat = $resultatSQL[0];
        }else {
            $resultat = "null";
        }

		return $resultat;
    }

	public function getPermissionReponseParIdUtilisateur($idReponse, $idUtilisateur): string{
        $pdo = Model::getPdo();
        $query = "SELECT permission FROM ".$this->getNomTable()." WHERE idReponse=:idReponse AND idUtilisateur=:idUtilisateur;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
                "idReponse" => $idReponse,
				"idUtilisateur" => $idUtilisateur);

        $pdoStatement->execute($values);

        if($pdoStatement->rowCount() > 0){
            $resultatSQL = $pdoStatement->fetch();

            $resultat = $resultatSQL['permission'];
        }else {
            $resultat="null";
        }

		return $resultat;
    }

    public function getListePermissionParQuestion($idQuestion){
        $pdo = Model::getPdo();
        $query = "SELECT * FROM ".$this->getNomTable()." WHERE idQuestion=:idQuestion;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion);

        $pdoStatement->execute($values);

        $res = [];
        foreach ($pdoStatement as $item){
            $res[] = $this->construire($item);
        }

        return $res;
    }

    public function deleteAllPermissionForIdQuestion($idQuestion): void{
        $pdo = Model::getPdo();
        $query = "DELETE FROM ".$this->getNomTable()." WHERE idQuestion=:idQuestion;";
        $pdoStatement = $pdo->prepare($query);

        $values = array(
            "idQuestion" => $idQuestion);

        $pdoStatement->execute($values);
    }
}