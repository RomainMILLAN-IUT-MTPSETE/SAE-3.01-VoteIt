<?php
namespace App\VoteIt\Model\Repository;

use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\Repository\DatabaseConnection as Model;

class UtilisateurRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "vit_Utilisateurs";
    }

    protected function construire(array $objetFormatTableau): Utilisateur{
        return new Utilisateur($objetFormatTableau['idUtilisateur'], $objetFormatTableau['motDePasseUtilisateur'], $objetFormatTableau['nomUtilisateur'], $objetFormatTableau['prenomUtilisateur'], $objetFormatTableau['dateNaissanceUtilisateur'], $objetFormatTableau['iconeLink'], $objetFormatTableau['mailUtilisateur'], $objetFormatTableau['mailAValider'], $objetFormatTableau['nonce'], $objetFormatTableau['gradeUtilisateur']);
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
            7 => 'mailAValider',
            8 => 'nonce',
            9 => 'gradeUtilisateur'];
    }

    /**
     * Retourne un utilisateur par son mail
     * @param $mail
     * @return Utilisateur|null
     */
    public function selectUserByMail($mail): ?Utilisateur{
        $sql = " SELECT * FROM vit_Utilisateurs WHERE mailUtilisateur=:mailUtilisateur";
        // Préparation de la requête
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "mailUtilisateur" => $mail,
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

    /*
     * DASHBOARD
     */
    /**
     * Retourne le nombre de compte
     * @return int
     */
    public function countNbAccount(): int{
        $pdo = Model::getPdo();
        $query = "SELECT COUNT(idUtilisateur) as nbAccount FROM ".$this->getNomTable().";";
        $pdoStatement = $pdo->query($query);
        $resultatSQL = $pdoStatement->fetch();

        $resultat = $resultatSQL['nbAccount'];

        if($resultat == null){
            $resultat = 0;
        }

        return $resultat;
    }
}
