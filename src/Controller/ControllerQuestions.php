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
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Crée une question", 'cheminVueBody' => "questions/create.php"]);
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('QC-1');
    }



    public static function created(){
        if(isset($_POST['autheur']) AND isset($_POST['titreQuestion']) AND isset($_POST['texteQuestion']) AND isset($_POST['planQuestion']) AND isset($_POST['categorieQuestion']) AND isset($_POST['ecritureDateDebut']) AND isset($_POST['ecritureDateFin']) AND isset($_POST['voteDateDebut']) AND isset($_POST['voteDateFin'])){
            $autheur = $_POST['autheur'];
            $titreQuestion = $_POST['titreQuestion'];
            $texteQuestion = $_POST['texteQuestion'];
            $planQuestion = $_POST['planQuestion'];
            $categorieQuestion = $_POST['categorieQuestion'];
            $ecritureDateDebut = $_POST['ecritureDateDebut'];
            $ecritureDateFin = $_POST['ecritureDateFin'];
            $voteDateDebut = $_POST['voteDateDebut'];
            $voteDateFin = $_POST['voteDateFin'];
            $idQuestion = ((new QuestionsRepository())->getIdQuestionMax())+1;

            (new QuestionsRepository())->createQuestion($autheur, $titreQuestion, $texteQuestion, $planQuestion, $ecritureDateDebut, $ecritureDateFin, $voteDateDebut, $voteDateFin, $categorieQuestion);
            self::home();
        }else {
            ControllerErreur::erreurCodeErreur('QC-2');
        }
    }
}
