<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\QuestionsRepository;
use App\VoteIt\Model\Repository\ReponsesRepository;

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
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Questions", 'cheminVueBody' => "questions/see.php", "question" => $question, "reponses" => $reponses]);
        }else {
            //Renvoye a la page d'erreur avec l'erreur QC-2
            ControllerErreur::erreurCodeErreur('QC-2');
        }
    }

    public static function error(){
        ControllerErreur::erreurCodeErreur('QC-1');
    }
}
