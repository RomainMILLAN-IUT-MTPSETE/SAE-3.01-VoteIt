<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Controller\ControllerErreur;
use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\DataObject\ReponseSection;
use App\VoteIt\Model\DataObject\Reponse;
use App\VoteIt\Model\Repository\PermissionsRepository;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponseSectionRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
use App\VoteIt\Model\Repository\SectionRepository;
use App\VoteIt\Model\Repository\UtilisateurRepository;
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
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Réponse", 'cheminVueBody' => "reponses/see.php", 'reponse' => $reponse, 'sectionsReponse' => $sectionsReponse, 'question' => $question]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function update() {
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->select($_GET['idReponse']);
            $reponseSection = (new ReponseSectionRepository())->selectAllByIdReponse($reponse->getIdReponse());
            //Liste des utilisateur qui sont des co-auteur
            $coauteur = (new PermissionsRepository())->getListePermissionCoAuteurParReponse($reponse->getIdReponse());
            $coauteurStr = '';
            foreach ($coauteur as $item){
                $coauteurStr = $coauteurStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
            }
            $coauteurStr = substr($coauteurStr, 2);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une réponse", 'cheminVueBody' => "reponses/update.php", 'reponse' => $reponse, 'reponseSection' => $reponseSection, 'coauteurStr' => $coauteurStr]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function delete() {
        if (isset($_GET['idReponse'])) {
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Suppression de la réponse", 'cheminVueBody' => "reponses/delete.php"]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }

    public static function vote(){
        if(isset($_GET['idReponse'])){
            self::afficheVue('view.php', ['pagetitle' => 'VoteIt - Voter pour une réponse', 'cheminVueBody' => "reponses/voter.php"]);
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

            //SUPPRESION DES PERMISSION EXISTANTE
            (new PermissionsRepository())->deleteAllPermissionForIdReponse($idReponse);

            //RECUPERATION DE LA LISTE DES UTILISATEUR CO-AUTEUR
            $coauteurInput = $_POST['userCoAuteur'];
            if(strlen($coauteurInput) > 0){
                //SEPARATION EN ARGUMENT
                $coauteurInputArgs = explode(", ", $coauteurInput);
                //POUR TOUS LES UTILISATEUR
                foreach ($coauteurInputArgs as $item){
                    //J'ENTRE LEUR NOUVELLE PERMISSION
                    (new PermissionsRepository())->addReponsePermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $idReponse, "CoAuteur");
                }
            }

            MessageFlash::ajouter("success", "Réponse créée.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$idQuestion);
            exit();
        }else {
            ControllerErreur::erreurCodeErreur(('RC-2'));
        }
    }

    public static function updated() {
        if(isset($_POST['idReponse']) and isset($_POST['autheur']) AND isset($_POST['titreReponse']) AND isset($_POST['nbSection']) AND isset($_POST['idQuestion'])){
            $modelReponse = new Reponse($_POST['idReponse'], $_POST['idQuestion'], $_POST['titreReponse'], $_POST['autheur']);
            (new ReponsesRepository())->update($modelReponse);

            for($i=1; $i<$_POST['nbSection']+1; $i++){
                $modelSection = new ReponseSection($_POST['idSection'.$i], $_POST['idReponse'], $_POST['texteSection'.$i]);
                (new ReponseSectionRepository())->updateReponseSection($modelSection);
            }

            //SUPPRESION DES PERMISSION EXISTANTE
            (new PermissionsRepository())->deleteAllPermissionForIdReponse($_POST['idReponse']);

            //RECUPERATION DE LA LISTE DES UTILISATEUR CO-AUTEUR
            $coauteurInput = $_POST['userCoAuteur'];
            if(strlen($coauteurInput) > 0){
                //SEPARATION EN ARGUMENT
                $coauteurInputArgs = explode(", ", $coauteurInput);
                //POUR TOUS LES UTILISATEUR
                foreach ($coauteurInputArgs as $item){
                    //J'ENTRE LEUR NOUVELLE PERMISSION
                    (new PermissionsRepository())->addReponsePermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $_POST['idReponse'], "CoAuteur");
                }
            }

            MessageFlash::ajouter("info","Réponse mise à jour.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$_POST['idQuestion']);
            exit();
        }else {
            header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
            exit();
        }
    }

    public static function deleted(){
        if(isset($_POST['idReponse'])){
            $idQuestion = (new ReponsesRepository())->selectReponseByIdReponse($_POST['idReponse'])->getIdQuestion();
            (new ReponsesRepository())->deleteReponseByIdReponse($_POST['idReponse']);
            
            MessageFlash::ajouter("danger", "Réponse supprimée.");
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
            $reponse = (new ReponsesRepository())->selectReponseByIdReponse($_POST['idReponse']);

            MessageFlash::ajouter("success", "Vous venez de voter pour la réponse.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$reponse->getIdQuestion());
            exit();
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }





    /*
     * CO AUTEUR
     */
    public static function updatecoauteur() {
        if(isset($_GET['idReponse'])){
            $reponse = (new ReponsesRepository())->select($_GET['idReponse']);
            $reponseSection = (new ReponseSectionRepository())->selectAllByIdReponse($reponse->getIdReponse());
            //Liste des utilisateur qui sont des co-auteur
            $coauteur = (new PermissionsRepository())->getListePermissionCoAuteurParReponse($reponse->getIdReponse());
            $coauteurStr = '';
            foreach ($coauteur as $item){
                $coauteurStr = $coauteurStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
            }
            $coauteurStr = substr($coauteurStr, 2);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une réponse", 'cheminVueBody' => "reponses/coauteur-update.php", 'reponse' => $reponse, 'reponseSection' => $reponseSection]);
        }else {
            ControllerErreur::erreurCodeErreur('RC-2');
        }
    }
    public static function updatedcoauteur() {
        if(isset($_POST['idReponse']) AND isset($_POST['nbSection']) AND isset($_POST['idQuestion'])){

            for($i=1; $i<$_POST['nbSection']+1; $i++){
                $modelSection = new ReponseSection($_POST['idSection'.$i], $_POST['idReponse'], $_POST['texteSection'.$i]);
                (new ReponseSectionRepository())->updateReponseSection($modelSection);
            }

            MessageFlash::ajouter("info","Réponse mise à jour.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$_POST['idQuestion']);
            exit();
        }else {
            header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
            exit();
        }
    }



}