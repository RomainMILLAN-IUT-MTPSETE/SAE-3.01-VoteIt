<?php

namespace App\VoteIt\Controller;

use App\VoteIt\Lib\ConnexionUtilisateur;
use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\UtilisateurRepository;
use http\Message;

class ControllerDashboard{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function dashboard(){
        if(strcmp((new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getGrade(), "Administrateur") == 0){
            $usersList = (new UtilisateurRepository())->selectAll();
            $idQuestionListToProposer = (new QuestionsRepository())->getAllIdQuestionToProposer();
            $nbQuestionActives = (new QuestionsRepository())->countNbQuestionActive();
            $nbAccounts = (new UtilisateurRepository())->countNbAccount();

            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Dashboard", 'cheminVueBody' => "dashboard/dashboard.php", "usersList" => $usersList, 'idQuestionListToProposer' => $idQuestionListToProposer, 'nbQuestionsActives' => $nbQuestionActives, 'nbAccounts' => $nbAccounts]);
        }else {
            header("Location: frontController.php");
            exit();
        }
    }

    public static function editPermission(){
        if(strcmp((new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getGrade(), "Administrateur") == 0){
            if(count($_POST) > 0){
                $usersList = (new UtilisateurRepository())->selectAll();

                foreach ($usersList as $item) {
                    if(isset($_POST["".$item->getIdentifiant()])){
                        if(strcmp($item->getGrade(), $_POST["".$item->getIdentifiant()]) != 0){
                            $item->setGrade($_POST["".$item->getIdentifiant()]);
                            (new UtilisateurRepository())->update($item);
                        }
                    }
                }

                MessageFlash::ajouter("success", "Grades modifiée");
                header("Location: frontController.php?controller=dashboard&action=dashboard");
                exit();
            }else {
                MessageFlash::ajouter("warning", "Merci de rentrer des valeurs");
                header("Location: frontController.php?controller=dashboard&action=dashboard");
                exit();
            }
        }else {
            header("Location: frontController.php");
            exit();
        }
    }

    public static function changeProposerQuestion(){
        if(strcmp((new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getGrade(), "Administrateur") == 0){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $q = (new QuestionsRepository())->select($id);

                if($q != null){
                    self::afficheVue("view.php", ['pagetitle' => "VoteIt - Modification proposition de question", 'cheminVueBody' => 'dashboard/updatequestionproposition.php', 'id' => $id, 'titre' => $q->getTitreQuestion()]);
                }else {
                    MessageFlash::ajouter("warning", "Aucune question trouvé avec cette identifiant");
                    header("Location: frontController.php?controller=dashboard&action=dahboard");
                    exit();
                }
            }else {
                MessageFlash::ajouter("warning", "Aucun identifiant renseigner");
                header("frontController.php?controller=dashboard&action=dashboard");
                exit();
            }
        }else {
            header("Location: frontController.php");
            exit();
        }
    }

    public static function updatequestionproposition(){
        if(strcmp((new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getGrade(), "Administrateur") == 0){
            if(isset($_POST['idQuestion'])){
                $id = $_POST['idQuestion'];
                $q = (new QuestionsRepository())->select($id);

                if($q != null){
                    $q->setEstProposer(false);

                    (new QuestionsRepository())->updateQuestion($q);

                    MessageFlash::ajouter("success", "Question n°".$q->getIdQuestion()." à était poser");
                    header("Location: frontController.php?controller=dashboard&action=dashboard");
                    exit();
                }else {
                    MessageFlash::ajouter("warning", "Aucune question trouvé avec cette identifiant");
                    header("Location: frontController.php?controller=dashboard&action=dahboard");
                    exit();
                }
            }else {
                MessageFlash::ajouter("warning", "Aucun identifiant renseigner");
                header("frontController.php?controller=dashboard&action=dashboard");
                exit();
            }
        }else {
            header("Location: frontController.php");
            exit();
        }
    }
}