<?php
namespace App\VoteIt\Controller;

class ControllerProfil{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function inscription(){
        self::afficheVue('view.php', ['pagetitle' => "Inscription", 'cheminVueBody' => "profil/inscription.php"]);
    }

    public static function connection(){
        self::afficheVue('view.php', ['pagetitle' => "Connection", 'cheminVueBody' => "profil/connection.php"]);
    }
}
