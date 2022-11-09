<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Utilisateurs";
    }

    protected function construire(array $objetFormatTableau): Utilisateur{
        return new Utilisateur($objetFormatTableau['idUtilisateur'], $objetFormatTableau['motDePasseUtilisateur'], $objetFormatTableau['nomUtilisateur'], $objetFormatTableau['prenomUtilisateur'], $objetFormatTableau['dateNaissanceUtilisateur'], $objetFormatTableau['iconeLink'], $objetFormatTableau['mailUtilisateur'], $objetFormatTableau['gradeUtilisateur']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idUtilisateur";
    }

    protected function getNomsColonnes(): array{
        return [ 0 => 'idUtilisateur',
            1 => 'motDePasseUtilisateur',
            2 => 'nomUtilisateur',
            3 => 'prenomUtilisateur',
            4 => 'dateNaissanceUtilisateur',
            5 => 'iconeLink',
            6 => 'mailUtilisateur',
            7 => 'gradeUtilisateur'];
    }
    
    public static function selectUserByIdUser($idUser){
        $sql = " SELECT * FROM vit_Utilisateurs WHERE idUtilisateur=:valuePrimaire";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "valuePrimaire" => $valuePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas de voiture correspondante
        $ressultatSQL = $pdoStatement->fetch();

        if (!$ressultatSQL) {

            $res = null;

        } else {

            $res = static::construire($ressultatSQL);

        }

        return $res;
    }

    public static function connectionCheckBD($identifiant, $password) : bool{
        $user = (new UtilisateurRepository())->select($identifiant);

        if(strcmp($password, $user->getMotDePasse()) == 0){
            return true;
        }else {
            return false;
        }
    }
}
