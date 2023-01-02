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

            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Dashboard", 'cheminVueBody' => "dashboard/dashboard.php", "usersList" => $usersList, 'idQuestionListToProposer' => $idQuestionListToProposer]);
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
}