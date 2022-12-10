<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\DataObject\Section;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
use App\VoteIt\Model\Repository\SectionRepository;
use http\Message;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        //Recuperation de toutes les questions
        $questions = (new QuestionsRepository())->selectAll();
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
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une question", 'cheminVueBody' => "questions/update.php"
            , 'question' => (new QuestionsRepository())->select($_GET['idQuestion']), 'sectionIds' => $sectionId]);
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

                (new QuestionsRepository())->createQuestion($idQuestion, $autheur, $titreQuestion, $ecritureDateDebut, $ecritureDateFin, $voteDateDebut, $voteDateFin, $categorieQuestion);

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


                MessageFlash::ajouter("info","Question n°" . $_POST['idQuestion'] . " modifiée");
                header("Location: frontController.php?controller=questions&action=see&idQuestion=".$_POST['idQuestion']);
                exit();
            }
        }else {
            header("Location: frontController.php?controller=questions&action=update&idQuestion=".$_POST['idQuestion']);
            exit();
        }

    }

    public static function deleted(){
        (new QuestionsRepository())->delete($_GET['idQuestion']);
        (new ReponsesRepository())->deleteReponseByIdQuestion($_GET['idQuestion']);
        (new SectionRepository())->deleteSectionByIdQuestion($_GET['idQuestion']);
        MessageFlash::ajouter("danger","Question n°" . $_GET['idQuestion'] . " supprimée");
        header("Location: frontController.php?controller=questions&action=home");
        exit();
    }
}
