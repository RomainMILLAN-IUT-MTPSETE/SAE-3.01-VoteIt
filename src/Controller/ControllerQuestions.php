<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Model\DataObject\Question;
use App\VoteIt\Model\Repository\QuestionsRepository;

class ControllerQuestions{
    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        $questions = (new QuestionsRepository())->selectAll();
        self::afficheVue('view.php', ['pagetitle' => "VoteIt", 'cheminVueBody' => "questions/home.php", 'questions' => $questions]);
    }

    public static function see(){
        if(isset($_GET['idQuestion'])){
            $idQuestion = $_GET['idQuestion'];
            $question = (new QuestionsRepository())->select($idQuestion);
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Questions", 'cheminVueBody' => "questions/see.php", "question" => $question]);
        }
    }
}
