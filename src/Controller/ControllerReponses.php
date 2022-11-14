<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Model\Repository\QuestionsRepository;

class ControllerReponses{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function create(){
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Creation de réponse", 'cheminVueBody' => "reponses/create.php"]);
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('RC-1');
    }

}