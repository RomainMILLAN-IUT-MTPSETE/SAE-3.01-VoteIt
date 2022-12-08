<?php
namespace App\VoteIt\Model\HTTP;

class Cookie{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void{
        if($dureeExpiration == null){
            setcookie($cle, serialize($valeur));
        }else{
            setcookie($cle, serialize($valeur), $dureeExpiration);
        }
    }

    public static function lire(string $cle): mixed{
        if(self::contient($cle)){
            return unserialize($_COOKIE[$cle]);
        }else {
            return null;
        }
    }

    public static function contient($cle) : bool{
        return array_key_exists($cle, $_COOKIE);
    }

    public static function supprimer($cle) : void{
        if(self::contient($cle)){
            unset($_COOKIE[$cle]);
            self::enregistrer($cle, '', 1);
        }
    }

}