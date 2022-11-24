<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Lib\MessageFlash;
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
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Creation d'une réponse", 'cheminVueBody' => "reponses/create.php", 'sections' => $sections]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function see(){
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->selectReponseByIdReponse($_GET['idReponse']);
            $sectionsReponse = (new ReponseSectionRepository())->selectAllByIdReponse($reponse->getIdReponse());
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Réponse n°" . $reponse->getIdReponse(), 'cheminVueBody' => "reponses/see.php", 'reponse' => $reponse, 'sectionsReponse' => $sectionsReponse]);
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

            for($i=1; $i<$nbSection+1; $i++){
                $texteSection = $_POST['texteSection' . $i];
                $idSection = $_POST['idSection'.$i];

                $ReponseSection = new ReponseSection($idSection, $idReponse, $texteSection);
                (new ReponseSectionRepository())->createReponseSection($ReponseSection);
            }

            MessageFlash::ajouter("success", "Réponse n°". $idReponse ." crée !");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$idQuestion);
            exit();
            //header("Location: frontController.php?controller=reponses&idReponse=".$)
        }else {
            ControllerErreur::erreurCodeErreur(('RC-2'));
        }
    }

    public static function update() {
        $sectionId = (new SectionRepository())->selectAllByIdQuestion($_GET['idReponse']);
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une réponse", 'cheminVueBody' => "reponses/update.php"
            , 'reponse' => (new ReponsesRepository())->select($_GET['idReponse']), 'sectionIds' => $sectionId]);
    }

    public static function updated() {
        if(isset($_POST['idReponse']) and isset($_POST['idQuestion']) AND isset($_POST['titreReponse']) AND isset($_POST['autheurId']) AND isset($_POST['nbVote'])){
            $modelReponse = new Reponse($_POST['idReponse'], $_POST['idQuestion'], $_POST['titreReponse'], $_POST['autheurId'], $_POST['nbVote']);
            (new ReponsesRepository())->update($modelReponse);
            MessageFlash::ajouter("info","Réponse n°" . $_POST['idReponse'] . " mise à jour !");
            header("Location: frontController.php?controller=reponses&action=home");
            exit();
        }else {
            header("Location: frontController.php?controller=reponses&action=update&idReponse=".$_POST['idReponse']);
            exit();
        }
    }

    public static function delete() {
        if (isset($_GET['idReponse'])) {
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Suppression de la réponse n°" . $_GET['idReponse'], 'cheminVueBody' => "reponses/delete.php"]);
        }
        else {
            echo 'l\'identifiant de la réponse non renseignée !';
        }
    }

}