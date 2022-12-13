<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\Repository\PermissionsRepository;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
use App\VoteIt\Model\Repository\SectionRepository;
use App\VoteIt\Model\Repository\UtilisateurRepository;
use http\Message;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        //Recuperation de toutes les questions
        $questions = (new QuestionsRepository())->selectAllQuestionVisible();
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Liste des Questions", 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
    }

    public static function see(){
        //Si idQuestion existe
        if(isset($_GET['idQuestion'])){
            $idQuestion = $_GET['idQuestion'];
            //Recuperation des infos de la BD
            $question = (new QuestionsRepository())->select($idQuestion);
            //Recuperation des réponses de la questions dans la BD
            $reponses = (new ReponsesRepository())->selectAllReponeByQuestionId($idQuestion);
            //Recuperation des sections de la questions dans la BD
            $sections = (new SectionRepository())->selectAllByIdQuestion($idQuestion);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Questions", 'cheminVueBody' => "questions/see.php", "question" => $question, "reponses" => $reponses, "sections" => $sections]);
        }else {
            //Renvoye a la page d'erreur avec l'erreur QC-2
            ControllerErreur::erreurCodeErreur('QC-2');
        }
    }

    public static function recherche(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];

            $questions = (new QuestionsRepository())->recherche($search);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Recherche: " . $search, 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
        }
    }

    public static function create(){
        $categories = (new \App\VoteIt\Model\Repository\CategorieRepository())->selectAll();
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Creation d'une question", 'cheminVueBody' => "questions/create.php", 'categories' => $categories]);
    }

    public static function update() {
        $sectionId = (new SectionRepository())->selectAllByIdQuestion($_GET['idQuestion']);
        $question = (new QuestionsRepository())->select($_GET['idQuestion']);
        //Liste des utilisateur qui sont des responsable
        $resp = (new PermissionsRepository())->getListePermissionResponsableParQuestion($_GET['idQuestion']);
        $respStr = '';
        foreach ($resp as $item){
            $respStr = $respStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
        }
        $respStr = substr($respStr, 2);
        //Liste des utilisateur ayant la permission de voter
        $userVotant = (new PermissionsRepository())->getListePermissionVotantParQuestion($_GET['idQuestion']);
        $userVotantStr = '';
        foreach ($userVotant as $item){
            $userVotantStr = $userVotantStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
        }
        $userVotantStr = substr($userVotantStr, 2);
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une question", 'cheminVueBody' => "questions/update.php"
            , 'question' => $question, 'sectionIds' => $sectionId, 'responsable' => $respStr, 'userVotant' => $userVotantStr]);
    }

    public static function delete() {
        if (isset($_GET['idQuestion'])) {
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Suppression d'une question", 'cheminVueBody' => "questions/delete.php"]);
        }
        else {
            echo 'Identifiant de la question non renseignée !';
        }
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('QC-1');
    }

    public static function created(){
        if(isset($_POST['autheur']) AND isset($_POST['titreQuestion']) AND isset($_POST['nbSection']) AND isset($_POST['categorieQuestion']) AND isset($_POST['ecritureDateDebut']) AND isset($_POST['ecritureDateFin']) AND isset($_POST['voteDateDebut']) AND isset($_POST['voteDateFin'])){
            if($_POST['ecritureDateDebut'] > $_POST['ecritureDateFin']){
                MessageFlash::ajouter("danger", "La date de début d'écriture est supérieure à la date de fin d'écriture.");
                header("Location: frontController.php?controller=questions&action=create");
                exit();
            }else if($_POST['voteDateDebut'] > $_POST['voteDateFin']){
                MessageFlash::ajouter("danger", "La date de début de vote est supérieure à la date de fin de vote.");
                header("Location: frontController.php?controller=questions&action=create");
                exit();
            }else if($_POST['ecritureDateFin'] > $_POST['voteDateDebut']){
                MessageFlash::ajouter("danger", "Les dates de vote sont avant les dates d'écriture.");
                header("Location: frontController.php?controller=questions&action=create");
                exit();
            }else {
                $autheur = $_POST['autheur'];
                $titreQuestion = $_POST['titreQuestion'];
                $nbSection = $_POST['nbSection'];
                $categorieQuestion = $_POST['categorieQuestion'];
                $ecritureDateDebut = $_POST['ecritureDateDebut'];
                $ecritureDateFin = $_POST['ecritureDateFin'];
                $voteDateDebut = $_POST['voteDateDebut'];
                $voteDateFin = $_POST['voteDateFin'];
                $idQuestion = ((new QuestionsRepository())->getIdQuestionMax())+1;

                (new QuestionsRepository())->createQuestion($idQuestion, $autheur, $titreQuestion, $ecritureDateDebut, $ecritureDateFin, $voteDateDebut, $voteDateFin, $categorieQuestion, true);




                //SUPPRESION DES PERMISSION EXISTANTE
                (new PermissionsRepository())->deleteAllPermissionForIdQuestion($idQuestion);

                //RECUPERATION DE LA LISTE DES UTILISATEUR
                $responsableReponse = $_POST['respReponse'];
                if(strlen($responsableReponse) > 0){
                    //SEPARATION EN ARGUMENT
                    $responsableReponseArgs = explode(", ", $responsableReponse);
                    //POUR TOUS LES UTILISATEUR
                    foreach ($responsableReponseArgs as $item){
                        //J'ENTRE LEUR NOUVELLE PERMISSION
                        (new PermissionsRepository())->addQuestionPermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $idQuestion, "ResponsableDeProposition");
                    }
                }

                //RECUPERATION DE LA LISTE DES VOTANT
                $votant = $_POST['userVotant'];
                //SI IL Y A UN UTILISATEUR
                if(strlen($votant) > 0){
                    //SEPARATION EN ARGUMENT
                    $votantArgs = explode(', ', $votant);
                    //POUR TOUS LES ARGUMENT
                    foreach ($votantArgs as $item){
                        //J'ENTRE LA PERMISSION DANS LA BDD
                        (new PermissionsRepository())->addQuestionPermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $idQuestion, "Votant");
                    }
                }

                header("Location: frontController.php?controller=sections&action=createSectionForCreateQuestion&idQuestion=".$idQuestion."&nbSections=".$nbSection);
                exit();
            }
        }else {
            ControllerErreur::erreurCodeErreur('QC-2');
        }
    }

    public static function updated() {
        if(isset($_POST['idQuestion']) AND isset($_POST['autheur']) AND isset($_POST['titreQuestion']) AND isset($_POST['ecritureDateDebut']) AND isset($_POST['ecritureDateFin']) AND isset($_POST['voteDateDebut']) AND isset($_POST['voteDateFin']) AND isset($_POST['categorieQuestion'])){
            if($_POST['ecritureDateDebut'] > $_POST['ecritureDateFin']){
                MessageFlash::ajouter("danger", "La date de début d'écriture est supérieure à la date de fin d'écriture.");
                header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
                exit();
            }else if($_POST['voteDateDebut'] > $_POST['voteDateFin']){
                MessageFlash::ajouter("danger", "La date de début de vote est supérieure à la date de fin de vote.");
                header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
                exit();
            }else if($_POST['ecritureDateFin'] > $_POST['voteDateDebut']){
                MessageFlash::ajouter("danger", "Les dates de vote sont avant les dates d'écriture.");
                header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
                exit();
            }else {
                $modelQuestion = new Question($_POST['idQuestion'],$_POST['autheur'],$_POST['titreQuestion'],$_POST['ecritureDateDebut'],$_POST['ecritureDateFin'],$_POST['voteDateDebut'],$_POST['voteDateFin'], $_POST['categorieQuestion']);
                (new QuestionsRepository())->updateQuestion($modelQuestion);

                $sectionId = (new SectionRepository())->selectAllByIdQuestion($_POST['idQuestion']);
                foreach($sectionId as $section){
                    $idSection = $section->getIdSection();
                    $titreSection = $_POST["sectionTitle" . $section->getIdSection()];
                    $descriptionSection = $_POST["sectionDesc" . $section->getIdSection()];

                    $modelSection = new Section($idSection, $_POST['idQuestion'], $titreSection, $descriptionSection);
                    (new SectionRepository())->updateSectionByIdSection($modelSection);
                }

                //SUPPRESION DES PERMISSION EXISTANTE
                (new PermissionsRepository())->deleteAllPermissionForIdQuestion($_POST['idQuestion']);

                //RECUPERATION DE LA LISTE DES UTILISATEUR
                $responsableReponse = $_POST['respReponse'];
                if(strlen($responsableReponse) > 0){
                    //SEPARATION EN ARGUMENT
                    $responsableReponseArgs = explode(", ", $responsableReponse);
                    //POUR TOUS LES UTILISATEUR
                    foreach ($responsableReponseArgs as $item){
                        //J'ENTRE LEUR NOUVELLE PERMISSION
                        (new PermissionsRepository())->addQuestionPermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $_POST['idQuestion'], "ResponsableDeProposition");
                    }
                }

                //RECUPERATION DE LA LISTE DES VOTANT
                $votant = $_POST['userVotant'];
                //SI IL Y A UN UTILISATEUR
                if(strlen($votant) > 0){
                    //SEPARATION EN ARGUMENT
                    $votantArgs = explode(', ', $votant);
                    //POUR TOUS LES ARGUMENT
                    foreach ($votantArgs as $item){
                        //J'ENTRE LA PERMISSION DANS LA BDD
                        (new PermissionsRepository())->addQuestionPermission((new UtilisateurRepository())->selectUserByMail($item)->getIdentifiant(), $_POST['idQuestion'], "Votant");
                    }
                }



                MessageFlash::ajouter("info","Question modifiée");
                header("Location: frontController.php?controller=questions&action=see&idQuestion=".$_POST['idQuestion']);
                exit();
            }
        }else {
            header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
            exit();
        }

    }

    public static function deleted(){
        (new QuestionsRepository())->setNonVisibleByIdQuestion($_GET['idQuestion']);
        MessageFlash::ajouter("danger","Question supprimée");
        header("Location: frontController.php?controller=questions&action=home");
        exit();
    }
}
