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
        //Si idUtilisateur existe
        if(isset($_GET['idUtilisateur'])){
            $idUser = $_GET['idUtilisateur'];
            //Recuperation de l'Utilisateur dans la BD
            $user = (new UtilisateurRepository())->select($idUser);

            //Si l'utilisateur est null
            if ($user == NULL) {
                //Renvoye a la page d'erreur avec la code PC-3
                ControllerErreur::erreurCodeErreur('PC-3');
            }
            self::afficheVue('view.php', ['pagetitle' => "Affichage", 'cheminVueBody' => "profil/home.php", 'user' => $user]);
        }else {
            //Renvoye a la page d'erreur avec la code PC-2
            ControllerErreur::erreurCodeErreur('PC-2');
        }
    }

    public static function inscription(){
        self::afficheVue('view.php', ['pagetitle' => "Inscription", 'cheminVueBody' => "profil/inscription.php"]);
    }

    public static function connection(){
        self::afficheVue('view.php', ['pagetitle' => "Connection", 'cheminVueBody' => "profil/connection.php"]);
    }

    public static function modification(){
        //Si idUtilisateur existe
        if(isset($_GET['idUtilisateur'])){
            $idUtilisateur = $_GET['idUtilisateur'];
            //Recuperation des infos de l'utilisateur dans la BD
            $user = (new UtilisateurRepository())->select($idUtilisateur);
        }else {
            //Sinon crée un utilisateur vide
            $user = new Utilisateur('', '', '', '', '','', '','');
        }
        self::afficheVue('view.php',['pagetitle'=>"Modification",'cheminVueBody'=>"profil/modification.php", 'user' => $user]);
    }

    public static function error(){
        //Renvoye a la page d'erreur avec le code PC-1
        ControllerErreur::erreurCodeErreur('PC-1');
    }



    //Function to not see
    public static function register(){
        //Si toutes les informations du formulaires ont était inscrite
        if(isset($_POST['identifiant']) AND isset($_POST['mail']) AND isset($_POST['password']) AND isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['dtnaissance']) AND isset($_POST['conditionandcasuse'])){
            $identifiant = $_POST['identifiant'];
            $password = $_POST['password'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $dtnaissance = $_POST['dtnaissance'];
            $condition = $_POST['conditionandcasuse'];

            //Si la condition à était check
            if($condition == true){
                //Création de l'utilisateut
                $user = new Utilisateur($identifiant, $password, $nom, $prenom, $dtnaissance, $mail, '1', 'user');
                //Import des infos dans la BD
                (new UtilisateurRepository())->create($user);
                self::home();
            }else {
                //Retourne vers la page d'inscription
                ControllerProfil::inscription();
            }
        }else {
            //Retourne vers la page d'inscription
            ControllerProfil::inscription();
        }
    }
    public static function connected(){
        //Si les informations du formulaire sont remplies
        if(isset($_POST['identifiant']) AND isset($_POST['password'])){
            $identifiant = $_POST['identifiant'];
            $password = $_POST['password'];

            //Si les informations de la BD correspondent
            if((new UtilisateurRepository())->connectionCheckBD($identifiant, $password) == true){
                self::home();
            }else {
                //Renvoye a la page d'erreur avec le code PC-4
                ControllerErreur::erreurCodeErreur('PC-4');
            }
        }
    }
    public static function edit(){
        //Si toutes les informations du formulaires sont remplies
        if(isset($_POST['identifiant']) AND isset($_POST['mail']) AND isset($_POST['password']) AND isset($_POST['prenom']) AND isset($_POST['nom']) AND isset($_POST['dtnaissance'])){
            $identifiant = $_POST['identifiant'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $prenom = $_POST['prenom'];
            $nom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $dtnaissance = $_POST['dtnaissance'];

            //Récuperation de l'utilisateur actuelle dans la BD
            $userBefore = (new UtilisateurRepository())->select($identifiant);
            $iconeLink = $userBefore->getIconeLink();
            $grade = $userBefore->getGrade();

            //Création d'un nouvelle utilisateur avec les nouvelles informations
            $userEdit = new Utilisateur($identifiant, $password, $prenom, $nom, $dtnaissance, $iconeLink, $mail, $grade);
            //Mise à jour de l'utilisateur
            (new UtilisateurRepository())->update($userEdit);
            //Redirection vers la page d'accueil
            header("Location: frontController.php?controller=profil&action=home&idUtilisateur=".$identifiant);
            exit();
        }else {
            //Si il y a au moins l'identifiant
            if(isset($_POST['identifiant'])){
                //Redirection vers la page de modification
                header("Location: frontController.php?controller=profil&action=modification&idUtilisateur=".$_POST['identifiant']);
                exit();
            }else{
                //Renvoye vers la page d'erreur avec le code PC-2
                ControllerErreur::erreurCodeErreur('PC-2');
            }
        }
    }
}
