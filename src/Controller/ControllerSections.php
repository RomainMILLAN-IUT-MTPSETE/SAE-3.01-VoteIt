<?php

namespace App\VoteIt\Controller;
use App\VoteIt\Controller\ControllerErreur;
use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\Repository\SectionRepository;
use App\VoteIt\Lib\MessageFlash;
use http\Message;

class ControllerSections{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function createSectionForCreateQuestion(){
        if(isset($_GET['nbSections']) AND isset($_GET['idQuestion'])){
            $nbSection = $_GET['nbSections'];
            $idQuestion = $_GET['idQuestion'];
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Création des sections", 'cheminVueBody' => "sections/createForCreateQuestion.php", 'nbSections' => $nbSection, 'idQuestion' => $idQuestion]);
        }else {
            MessageFlash::ajouter("warning", "Nombre de section et identifiant questions non données");
            header("Location: frontController.php?controller=questions&action=home");
            exit();
        }
    }

    public static function error(){
        MessageFlash::ajouter("warning", "Erreur sur la page Sections");
        header("Location: frontController.php?controller=questions&action=home");
        exit();
    }


    public static function created(){
        if(isset($_POST['nbSections']) AND isset($_POST['idQuestion']) AND isset($_POST['section1']) and isset($_POST['description1'])){
            $nbSections = $_POST['nbSections'];
            for($i=1; $i<$nbSections+1; $i++){
                $idSection = ((new SectionRepository())->getIdQuestionMax())+1;
                $idQuestion = $_POST['idQuestion'];
                $sectionName = 'section'.$i;
                $descriptionName = 'description'.$i;
                $section = $_POST[$sectionName];
                $description = $_POST[$descriptionName];
                $sectionTemp = new Section($idSection, $idQuestion, $section, $description);
                (new SectionRepository())->createSection($sectionTemp);
            }

            MessageFlash::ajouter("success", "Ajout de la question n°" . $_POST['idQuestion'] . " réussi!");
            header("Location: frontController.php?controller=questions&action=home");
            exit();
        }else {
            MessageFlash::ajouter("warning", "Nombre de section ou identifiant question manquant");
            header("Location: frontController.php?controller=questions&action=home");
            exit();
        }
    }


}