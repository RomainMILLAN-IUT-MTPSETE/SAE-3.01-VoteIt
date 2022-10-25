<?php
namespace App\VoteIt\Controller;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        self::afficheVue('view.php', ['pagetitle' => "VoteIt", 'cheminVueBody' => "questions/home.php"]);
    }
}
