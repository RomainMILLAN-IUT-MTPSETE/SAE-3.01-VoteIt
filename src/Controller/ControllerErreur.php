<?php
namespace App\VoteIt\Controller;

class ControllerErreur{

    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function erreurCodeErreur(String $codeErreur){
        self::afficheVue('view.php', ['pagetitle' => "Erreur", 'cheminVueBody' => 'erreur/home.php', 'codeErreur' => $codeErreur]);
    }

    public static function erreur(){
        self::afficheVue('view.php', ['pagetitle' => "Erreur", 'cheminVueBody' => 'erreur/home.php']);
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('EC-1');
    }
}
