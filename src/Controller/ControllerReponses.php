<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\SectionRepository;
use App\VoteIt\Controller\ControllerErreur;

class ControllerReponses{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function create(){
        if(isset($_GET['idQuestion'])){
            $sections = (new SectionRepository())->selectAllByIdQuestion($_GET['idQuestion']);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Creation de réponse", 'cheminVueBody' => "reponses/create.php", 'sections' => $sections]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('RC-1');
    }

}