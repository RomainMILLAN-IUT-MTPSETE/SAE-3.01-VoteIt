<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\Repository\UtilisateurRepository;

class ControllerProfil{

    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        self::afficheVue('view.php', ['pagetitle' => "Affichage", 'cheminVueBody' => "profil/home.php"]);
    }

    public static function inscription(){
        self::afficheVue('view.php', ['pagetitle' => "Inscription", 'cheminVueBody' => "profil/inscription.php"]);
    }

    public static function connection(){
        self::afficheVue('view.php', ['pagetitle' => "Connection", 'cheminVueBody' => "profil/connection.php"]);
    }



    //Function to not see
    public static function register(){
        if(isset($_POST['identifiant']) AND isset($_POST['password']) AND isset($_POST['mail']) AND isset($_POST['password']) AND isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['dtnaissance']) AND isset($_POST['conditionandcasuse'])){
            $identifiant = $_POST['identifiant'];
            $password = $_POST['password'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $dtnaissance = $_POST['dtnaissance'];
            $condition = $_POST['conditionandcasuse'];

            if($condition == true){
                $user = new Utilisateur($identifiant, $password, $nom, $prenom, $dtnaissance, $mail, '1', 'user');
                (new UtilisateurRepository())->create($user);
                self::home();
            }else {
                ControllerProfil::inscription();
            }
        }else {
            ControllerProfil::inscription();
        }
    }
    public static function connected(){
        if(isset($_POST['identifiant']) AND isset($_POST['password'])){
            $identifiant = $_POST['identifiant'];
            $password = $_POST['password'];

            if((new UtilisateurRepository())->connectionCheckBD($identifiant, $password) == true){
                self::home();
            }else {
                echo("NON OK");
            }
        }
    }
}
