<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;
use App\VoteIt\Model\Repository\SectionRepository;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        //Recuperation de toutes les questions
        $questions = (new QuestionsRepository())->selectAll();
        self::afficheVue('view.php', ['pagetitle' => "VoteIt", 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
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
            self::afficheVue('view.php', ['pagetitle' => "VoteIt", 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
        }
    }

    public static function create(){
        $categories = (new \App\VoteIt\Model\Repository\CategorieRepository())->selectAll();
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Crée une question", 'cheminVueBody' => "questions/create.php", 'categories' => $categories]);
    }

    public static function update() {
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Modifier une question", 'cheminVueBody' => "questions/update.php"
            , 'q' => (new QuestionsRepository())->select($_GET['idQuestion'])]);
    }

    public static function delete() {
        if (isset($_GET['idQuestion'])) {
            self::afficheVue('view.php',['pagetitle' => "VoteIt - Supprimer une question", 'cheminVueBody' => "questions/delete.php"]);
        }
        else {
            echo 'l\'identifiant de la question non renseignée !';
        }
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('QC-1');
    }



    public static function created(){
        if(isset($_POST['autheur']) AND isset($_POST['titreQuestion']) AND isset($_POST['nbSection']) AND isset($_POST['categorieQuestion']) AND isset($_POST['ecritureDateDebut']) AND isset($_POST['ecritureDateFin']) AND isset($_POST['voteDateDebut']) AND isset($_POST['voteDateFin'])){
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
            //ControllerSections::createSectionForCreateQuestion($idQuestion, $nbSection);
            header("Location: frontController.php?controller=sections&action=createSectionForCreateQuestion&idQuestion=".$idQuestion."&nbSections=".$nbSection);
            exit();
        }else {
            ControllerErreur::erreurCodeErreur('QC-2');
        }
    }

    public static function updated() {
        $modelQuestion = new Question($_GET['auteur'],$_GET['titreQuestion'],$_GET['texteQuestion'],$_GET['planQuestion'],$_GET['ecritureDateDebut'],$_GET['ecritureDateFin'],$_GET['VoteDateDebut'],$_GET['VoteDateFin'],$_GET['categorieQuestion']);
        (new QuestionsRepository())->update($modelQuestion);
        $questions = (new QuestionsRepository())->selectAll();
        header("Location: frontController.php?controller=questions&action=home");
        exit();
    }

    public static function deleted(){
        (new QuestionsRepository())->delete($_GET['idQuestion']);
        (new ReponsesRepository())->deleteReponseByIdQuestion($_GET['idQuestion']);
        (new SectionRepository())->deleteSectionByIdQuestion($_GET['idQuestion']);
        header("Location: frontController.php?controller=questions&action=home");
        exit();
    }
}
