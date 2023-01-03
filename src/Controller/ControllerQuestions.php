<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Lib\ConnexionUtilisateur;
use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\Repository\PermissionsRepository;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
use App\VoteIt\Model\Repository\SectionRepository;
use App\VoteIt\Model\Repository\UtilisateurRepository;
use \App\VoteIt\Model\Repository\CategorieRepository;
use App\VoteIt\Model\Repository\VoteRepository;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        //Recuperation de toutes les questions
        $questions = (new QuestionsRepository())->selectAllQuestionVisible();

        $peutProposerQuestion = self::getPeutProposerQuestion();
        $peutPoserQuestion = self::getPeutPoserQuestion();


        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Liste des Questions", 'cheminVueBody' => "questions/home.php", 'questions' => $questions, 'peutPoserQuestion' => $peutPoserQuestion, 'peutProposerQuestion' => $peutProposerQuestion]);
    }

    public static function see(){
        //Si idQuestion existe
        if(isset($_GET['idQuestion'])){
            $idQuestion = $_GET['idQuestion'];
            $question = (new QuestionsRepository())->select($idQuestion);
            $reponses = (new ReponsesRepository())->selectAllReponeByQuestionId($idQuestion);
            $sections = (new SectionRepository())->selectAllByIdQuestion($idQuestion);
            $auteur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($question->getAutheur());
            $allIdQuestion = (new QuestionsRepository())->allIdQuestion();
            $nbVote = (new VoteRepository())->getNbVoteForQuestion($_GET['idQuestion']);

            $userEstReponsableQuestion = (new PermissionsRepository())->getPermissionReponsableDePropositionParIdUtilisateurEtIdQuestion($idQuestion, ConnexionUtilisateur::getLoginUtilisateurConnecte());
            $periodeReponse =  false;
            $periodeVote = false;
            $nbVoteMax = (new ReponsesRepository())->getNbVoteMax($question->getIdQuestion());

            $dateNow = date("Y-m-d");
            if ($question->getDateEcritureDebut() <= $dateNow && $dateNow <= $question->getDateEcritureFin()){
                $periodeReponse = true;
                $periodeVote = false;
            }else if($question->getDateEcritureFin() <= $dateNow && $question->getDateVoteDebut() <= $dateNow && $dateNow <= $question->getDateVoteFin()){
                $periodeReponse = false;
                $periodeVote = true;
            }

            $canVote = false;
            $canModifOrDelete = false;
            $user = null;
            if (ConnexionUtilisateur::estConnecte()) {
                $user = (new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

                if((strcmp($question->getAutheur(), $user->getIdentifiant()) == 0) or (strcmp($user->getGrade(), "Administrateur") == 0)){
                    $canModifOrDelete = true;
                }

                if((new VoteRepository())->stateVote($_GET['idQuestion'], ConnexionUtilisateur::getLoginUtilisateurConnecte())){
                    $canVote = true;
                }
            }

            if($question->getDateVoteFin() <= $dateNow){
                $idReponseGagnante = (new VoteRepository())->getIdReponseGagnante($_GET['idQuestion']);
            }

            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Questions", 'cheminVueBody' => "questions/see.php", "question" => $question, "reponses" => $reponses, "sections" => $sections, 'estReponsable' => $userEstReponsableQuestion, 'periodeReponse' => $periodeReponse, 'periodeVote' => $periodeVote, 'user' => $user, 'canModifOrDelete' => $canModifOrDelete, 'auteur' => $auteur, 'nbVoteMax' => $nbVoteMax, 'allIdQuestion' => $allIdQuestion, 'nbVote' => $nbVote, 'canVote' => $canVote, 'idReponseGagnante' => $idReponseGagnante]);
        }else {
            MessageFlash::ajouter('warning', "Identifiant question manquant");
            header("Location: frontController.php?controller=questions&action=home");
            exit();
        }
    }

    public static function recherche(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];

            $questions = (new QuestionsRepository())->recherche($search);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Recherche: " . $search, 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
        }
    }

    public static function vote(){
        if(isset($_GET['idQuestion'])){
            $reponses = (new ReponsesRepository())->selectAllReponeByQuestionId($_GET['idQuestion']);
            self::afficheVue('view.php', ['pagetitle' => 'VoteIt - Voter pour une question', 'cheminVueBody' => "questions/voter.php", 'reponses' => $reponses]);
        }else {
            MessageFlash::ajouter("warning", "Identifiant Question manquant");
            header("Location: frontController.php?controller=question&action=home");
            exit();
        }
    }

    public static function create(){
        $categories = (new CategorieRepository())->selectAll();

        $peutProposerQuestion = self::getPeutProposerQuestion();
        $peutPoserQuestion = self::getPeutPoserQuestion();

        $idAuteur = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Creation d'une question", 'cheminVueBody' => "questions/create.php", 'categories' => $categories, 'poserQuestion' => $peutPoserQuestion, 'proposerQuestion' => $peutProposerQuestion, 'idAuteur' => $idAuteur]);
    }

    public static function update() {
        $sectionId = (new SectionRepository())->selectAllByIdQuestion($_GET['idQuestion']);
        $question = (new QuestionsRepository())->select($_GET['idQuestion']);
        //Liste des utilisateurs qui sont des responsables
        $resp = (new PermissionsRepository())->getListePermissionResponsableParQuestion($_GET['idQuestion']);
        $respStr = '';
        foreach ($resp as $item){
            $respStr = $respStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
        }
        $respStr = substr($respStr, 2);
        //Liste des utilisateurs ayant la permission de voter
        $userVotant = (new PermissionsRepository())->getListePermissionVotantParQuestion($_GET['idQuestion']);
        $userVotantStr = '';
        foreach ($userVotant as $item){
            $userVotantStr = $userVotantStr . ", " . (new UtilisateurRepository())->select($item->getIdUtilisateur())->getMail();
        }
        $userVotantStr = substr($userVotantStr, 2);

        $sectionPeutEtreModifier = false;
        $dateNow = date("Y-m-d");
        if ($question->getDateEcritureDebut() > $dateNow) {
            $sectionPeutEtreModifier = true;
        }
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une question", 'cheminVueBody' => "questions/update.php"
            , 'question' => $question, 'sectionIds' => $sectionId, 'responsable' => $respStr, 'userVotant' => $userVotantStr, "sectionPeutEtreModifier" => $sectionPeutEtreModifier]);
    }

    public static function delete() {
        if (isset($_GET['idQuestion'])) {
            $question = (new QuestionsRepository())->select($_GET['idQuestion']);
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Suppression d'une question", 'cheminVueBody' => "questions/delete.php", 'question' => $question]);
        }
        else {
            echo 'Identifiant de la question non renseignée !';
        }
    }

    public static function error(){
        MessageFlash::ajouter("warning", "Erreur sur la page de question");
        header("Location: frontController.php?controller=home&action=home");
        exit();
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
                if(isset($_POST['poserQuestion'])){
                    $estProposer = false;
                }else if(isset($_POST['proposerQuestion'])){
                    $estProposer = true;
                }

                (new QuestionsRepository())->createQuestion($idQuestion, $autheur, $titreQuestion, $ecritureDateDebut, $ecritureDateFin, $voteDateDebut, $voteDateFin, $categorieQuestion, true, $estProposer);

                //SUPPRESION DES PERMISSION EXISTANTE
                (new PermissionsRepository())->deleteAllPermissionForIdQuestion($idQuestion);

                //RECUPERATION DE LA LISTE DES UTILISATEUR
                $responsableReponse = $_POST['respReponse'];
                if(strlen($responsableReponse) > 0){
                    //SEPARATION EN ARGUMENT
                    $responsableReponseArgs = explode(", ", $responsableReponse);
                    //POUR TOUS LES UTILISATEURS
                    foreach ($responsableReponseArgs as $item){
                        //VERIFICATION MAIL UTILISATEUR
                        $user = (new UtilisateurRepository())->selectUserByMail($item);

                        if($user != null){
                            //J'ENTRE LEUR NOUVELLE PERMISSION
                            (new PermissionsRepository())->addQuestionPermission($user->getIdentifiant(), $idQuestion, "ResponsableDeProposition");
                        }else {
                            MessageFlash::ajouter("warning", "Utilisateur responsable non trouvé dans la base de donné, verifier l'email");
                        }
                    }
                }

                //RECUPERATION DE LA LISTE DES VOTANT
                $votant = $_POST['userVotant'];
                //SI IL Y A UN UTILISATEUR
                if(strlen($votant) > 0){
                    //SEPARATION EN ARGUMENT
                    $votantArgs = explode(', ', $votant);
                    //POUR TOUS LES ARGUMENTS
                    foreach ($votantArgs as $item){
                        //VERIFICATION MAIL UTILISATEUR
                        $user = (new UtilisateurRepository())->selectUserByMail($item);

                        if($user != null){
                            //J'ENTRE LEUR NOUVELLE PERMISSION
                            (new PermissionsRepository())->addQuestionPermission($user->getIdentifiant(), $idQuestion, "Votant");
                        }else {
                            MessageFlash::ajouter("warning", "Utilisateur votant non trouvé dans la base de donné, verifier l'email");
                        }
                    }

                }

                header("Location: frontController.php?controller=sections&action=createSectionForCreateQuestion&idQuestion=".$idQuestion."&nbSections=".$nbSection);
                exit();
            }
        }else {
            MessageFlash::ajouter('warning', "Information manquante");
            header("Location: frontController.php?controller=questions&action=create");
            exit();
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
                $modelQuestion = new Question($_POST['idQuestion'],$_POST['autheur'],$_POST['titreQuestion'],$_POST['ecritureDateDebut'],$_POST['ecritureDateFin'],$_POST['voteDateDebut'],$_POST['voteDateFin'], $_POST['categorieQuestion'], true,false);
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
                    //POUR TOUS LES UTILISATEURS
                    foreach ($responsableReponseArgs as $item){
                        $user = (new UtilisateurRepository())->selectUserByMail($item);

                        if($user != null){
                            //J'ENTRE LEUR NOUVELLE PERMISSION
                            (new PermissionsRepository())->addQuestionPermission($user->getIdentifiant(), $_POST['idQuestion'], "ResponsableDeProposition");
                        }else {
                            MessageFlash::ajouter("warning", "Utilisateur reponsable non trouvé dans la base de donné, verifier l'email");
                        }
                    }
                }

                //RECUPERATION DE LA LISTE DES VOTANT
                $votant = $_POST['userVotant'];
                //SI IL Y A UN UTILISATEUR
                if(strlen($votant) > 0){
                    //SEPARATION EN ARGUMENT
                    $votantArgs = explode(', ', $votant);
                    //POUR TOUS LES ARGUMENTS
                    foreach ($votantArgs as $item){
                        $user = (new UtilisateurRepository())->selectUserByMail($item);

                        if($user != null){
                            //J'ENTRE LA PERMISSION DANS LA BDD
                            (new PermissionsRepository())->addQuestionPermission($user->getIdentifiant(), $_POST['idQuestion'], "Votant");
                        }else {
                            MessageFlash::ajouter("warning", "Utilisateur votant non trouvé dans la base de donné, verifier l'email");
                        }
                    }
                }



                MessageFlash::ajouter("info","Question modifiée");
                header("Location: frontController.php?controller=questions&action=see&idQuestion=".$_POST['idQuestion']);
                exit();
            }
        }else {
            MessageFlash::ajouter("warning", "Il manque des informations");
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

    public static function voted(){
        if(isset($_POST['idQuestion'])){
            $reponsesQuestion = (new ReponsesRepository())->selectAllReponeByQuestionId($_POST['idQuestion']);

            foreach($reponsesQuestion as $reponse){
                if(isset($_POST[''.$reponse->getIdReponse()])){
                    $vote = $_POST[$reponse->getIdReponse()];
                    (new VoteRepository())->vote($reponse, $vote);
                }else {
                    (new VoteRepository())->vote($reponse, 0);
                }
            }

            MessageFlash::ajouter("success", "Vous venez de voter pour la question.");
            header("Location: frontController.php?controller=questions&action=see&idQuestion=".$reponse->getIdQuestion());
            exit();
        }else {
            MessageFlash::ajouter('warning', "Identifiant question manquant");
            header("Location: frontController.php?controller=question&action=home");
        }
    }





    public static function getPeutProposerQuestion(): bool{
        if(ConnexionUtilisateur::estConnecte()){
            $user = (new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

            if(strcmp($user->getGrade(), "Utilisateur") == 0){
                return true;
            }
        }
        
        return false;
    }
    public static function getPeutPoserQuestion(): bool{
        if(ConnexionUtilisateur::estConnecte()){
            $user = (new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

            if(strcmp($user->getGrade(), "Organisateur") == 0 OR strcmp($user->getGrade(), "Administrateur") == 0){
                return true;
            }
        }

        return false;
    }
}
