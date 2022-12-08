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
use App\VoteIt\Model\Repository\VoteRepository;

class ControllerReponses{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function create(){
        if(isset($_GET['idQuestion'])){
            $sections = (new SectionRepository())->selectAllByIdQuestion($_GET['idQuestion']);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Création d'une réponse", 'cheminVueBody' => "reponses/create.php", 'sections' => $sections]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function see(){
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->selectReponseByIdReponse($_GET['idReponse']);
            $question = (new QuestionsRepository())->select($reponse->getIdQuestion());
            $sectionsReponse = (new ReponseSectionRepository())->selectAllByIdReponse($reponse->getIdReponse());
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Réponse n°" . $reponse->getIdReponse(), 'cheminVueBody' => "reponses/see.php", 'reponse' => $reponse, 'sectionsReponse' => $sectionsReponse, 'question' => $question]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function update() {
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->select($_GET['idReponse']);
            $reponseSection = (new ReponseSectionRepository())->selectAllByIdReponse($reponse->getIdReponse());
            //$sections = (new SectionRepository())->selectAllByIdQuestion($reponse->getIdReponse());
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une réponse", 'cheminVueBody' => "reponses/update.php", 'reponse' => $reponse, 'reponseSection' => $reponseSection]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function delete() {
        if (isset($_GET['idReponse'])) {
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Suppression de la réponse n°" . $_GET['idReponse'], 'cheminVueBody' => "reponses/delete.php"]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function vote(){
        if(isset($_GET['idReponse'])){
            self::afficheVue('view.php', ['pagetitle' => 'VoteIt - Voter pour la réponse n°'.$_GET['idReponse'], 'cheminVueBody' => "reponses/voter.php"]);
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

            MessageFlash::ajouter("success", "Réponse n°". $idReponse ." créée.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$idQuestion);
            exit();
            //header("Location: frontController.php?controller=reponses&idReponse=".$)
        }else {
            ControllerErreur::erreurCodeErreur(('RC-2'));
        }
    }

    public static function updated() {
        if(isset($_POST['idReponse']) and isset($_POST['autheur']) AND isset($_POST['titreReponse']) AND isset($_POST['nbSection']) AND isset($_POST['idQuestion']) AND isset($_POST['nbVote'])){
            $modelReponse = new Reponse($_POST['idReponse'], $_POST['idQuestion'], $_POST['titreReponse'], $_POST['autheur'], $_POST['nbVote']);
            (new ReponsesRepository())->update($modelReponse);

            for($i=1; $i<$_POST['nbSection']+1; $i++){
                $modelSection = new ReponseSection($_POST['idSection'.$i], $_POST['idReponse'], $_POST['texteSection'.$i]);
                (new ReponseSectionRepository())->updateReponseSection($modelSection);
            }

            MessageFlash::ajouter("info","Réponse n°" . $_POST['idReponse'] . " mise à jour.");
            header("Location: frontController.php?controller=reponses&action=see&idReponse=".$_POST['idReponse']);
            exit();
        }else {
            header("Location: frontController.php?controller=reponses&action=update&idReponse=".$_POST['idReponse']);
            exit();
        }
    }

    public static function deleted(){
        if(isset($_POST['idReponse'])){
            $idQuestion = (new ReponsesRepository())->selectReponseByIdReponse($_POST['idReponse'])->getIdQuestion();
            (new ReponsesRepository())->deleteReponseByIdReponse($_POST['idReponse']);
            
            MessageFlash::ajouter("danger", "Réponse n°" . $_POST['idReponse'] . " supprimée.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$idQuestion);
            exit();
        }else {
            header("Location: frontController.php?controller=questions&action=home");
            exit();
        }
    }

    public static function voted(){
        if(isset($_POST['idReponse'])){
            (new VoteRepository())->vote((new ReponsesRepository())->selectReponseByIdReponse($_POST['idReponse']));

            MessageFlash::ajouter("success", "Vous venez de voter pour la réponse n°".$_POST['idReponse'].".");
            header("Location: frontController.php?controller=reponses&action=see&idReponse=".$_POST['idReponse'].".");
            exit();
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }



}