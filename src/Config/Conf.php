<?php
namespace App\VoteIt\Config;

class Conf {

    static private array $databases = array(
        // Le nom d'hote est webinfo a l'IUT
        // ou localhost sur votre machine
        //
        // ou webinfo.iutmontp.univ-montp2.fr
        // pour accéder à webinfo depuis l'extérieur
        'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
        // A l'IUT, vous avez une BDD nommee comme votre login
        // Sur votre machine, vous devrez creer une BDD
        'database' => 'pierreg',
        // A l'IUT, c'est votre login
        // Sur votre machine, vous avez surement un compte 'root'
        'login' => 'pierreg',
        // A l'IUT, c'est votre mdp (INE par defaut)
        // Sur votre machine personelle, vous avez creez ce mdp a l'installation
        'password' => 'Fortnite34'
    );

    static public function getLogin() : string {
        // L'attribut statique $databases s'obtient avec la syntaxe static::$databases
        // au lieu de $this->databases pour un attribut non statique
        return self::$databases['login'];
    }
    static public function getHostname() : string {
        return self::$databases['hostname'];
    }
    static public function getDatabase() : string {
        return self::$databases['database'];
    }
    static public function getPassword() : string {
        return self::$databases['password'];
    }

}
?>