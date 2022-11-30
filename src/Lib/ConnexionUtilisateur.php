<?php

namespace App\VoteIt\Lib;

use App\VoteIt\Model\HTTP\Session;
use App\VoteIt\Model\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        Session::getInstance()->enregistrer(ConnexionUtilisateur::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(ConnexionUtilisateur::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        if(ConnexionUtilisateur::estConnecte()){
            return Session::getInstance()->lire(ConnexionUtilisateur::$cleConnexion);
        }else {
            return null;
        }
    }

    public static function estUtilisateur($login): bool{
        $u = (new UtilisateurRepository())->select($login);

        if($u == null){
            return false;
        }else {
            return true;
        }
    }

    public static function estAdministrateur() : bool{
        if(ConnexionUtilisateur::estConnecte()){
            $u = (new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

            if($u->isEstAdmin() == true){
                return true;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }

}