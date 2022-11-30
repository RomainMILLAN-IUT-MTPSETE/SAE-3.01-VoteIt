<?php

namespace App\VoteIt\Lib;

use App\VoteIt\Config\Conf;
use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\Repository\UtilisateurRepository;

class VerificationEmail{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getIdentifiant());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $absoluteURL = Conf::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controller=profil&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation</a>";

        // Temporairement avant d'envoyer un vrai mail
        MessageFlash::ajouter("success", $corpsEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        if(ConnexionUtilisateur::estUtilisateur($login)){
            $user = (new UtilisateurRepository())->select($login);

            if(strcmp($user->getNonce(), $nonce) == 0){
                $user->setMail($user->getMailAValider());
                $user->setMailAValider("");
                $user->setNonce("");
                (new UtilisateurRepository())->update($user);
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
        return false;
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool
    {
        $user = (new UtilisateurRepository())->select($utilisateur->getLogin());
        if(strcmp($user->getEmailAValider(), "") == 0){
            return true;
        }else {
            return false;
        }
    }
}