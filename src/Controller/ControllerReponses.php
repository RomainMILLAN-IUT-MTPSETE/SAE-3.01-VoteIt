<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Model\DataObject\ReponseSection;
use App\VoteIt\Model\DataObject\Reponse;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponseSectionRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
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

    public static function see(){
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->selectReponseByIdReponse($_GET['idReponse']);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Réponse", 'cheminVueBody' => "reponses/see.php", 'reponse' => $reponse]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('RC-1');
    }


    //NOT SEE
    public static function created(){
        if(isset($_POST['idQuestion']) and isset($_POST['autheur']) AND isset($_POST['titreReponse']) AND isset($_POST['idSection1']) AND isset($_POST['nbSection']) AND isset($_POST['texteSection1'])){
            $idQuestion = $_POST['idQuestion'];
            $autheur = $_POST['autheur'];
            $titreReponse = $_POST['titreReponse'];
            $nbSection = $_POST['nbSection'];

            $idReponse = (new ReponsesRepository())->getIdReponseMax() + 1;

            $reponse = new Reponse($idReponse, $idQuestion, $titreReponse, $autheur, 0);

            (new ReponsesRepository())->createReponse($reponse);
            echo'Reponse Crée';

            for($i=1; $i<$nbSection+1; $i++){
                $texteSection = $_POST['texteSection' . $i];
                $idSection = $_POST['idSection'.$i];

                $ReponseSection = new ReponseSection($idSection, $idReponse, $texteSection);
                (new ReponseSectionRepository())->createReponseSection($ReponseSection);


            }

            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$idQuestion);
            exit();
            //header("Location: frontController.php?controller=reponses&idReponse=".$)
        }else {
            ControllerErreur::erreurCodeErreur(('RC-2'));
        }
    }

}