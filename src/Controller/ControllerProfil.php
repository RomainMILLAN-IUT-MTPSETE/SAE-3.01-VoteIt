<?php
namespace App\VoteIt\Controller;

use App\VoteIt\Lib\ConnexionUtilisateur;
use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Lib\MessageFlash as LibMessageFlash;
use App\VoteIt\Lib\MotDePasse;
use App\VoteIt\Lib\VerificationEmail;
use App\VoteIt\Model\DataObject\Utilisateur;
use App\VoteIt\Model\HTTP\Session;
use App\VoteIt\Model\Repository\UtilisateurRepository;

class ControllerProfil{

    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function home(){
        //Si idUtilisateur existe
        if(ConnexionUtilisateur::estConnecte() == true){
            $idUser = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            //Recuperation de l'Utilisateur dans la BD
            $user = (new UtilisateurRepository())->select($idUser);

            //Si l'utilisateur est null
            if ($user == NULL) {
                //Renvoye a la page d'erreur avec la code PC-3
                ControllerErreur::erreurCodeErreur('PC-3');
            }
            self::afficheVue('view.php', ['pagetitle' => "VoteIt - Profil", 'cheminVueBody' => "profil/home.php", 'user' => $user]);
        }else {
            //Renvoye a la page d'erreur avec la code PC-2
            //ControllerErreur::erreurCodeErreur('PC-2');

            //Renvoye vers le formulaire de connexion
            header("Location: frontController.php?controller=profil&action=connection");
            exit();
        }
    }

    public static function inscription(){
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Profil/Inscription", 'cheminVueBody' => "profil/inscription.php"]);
    }

    public static function connection(){
        self::afficheVue('view.php', ['pagetitle' => "VoteIt - Profil/Connection", 'cheminVueBody' => "profil/connection.php"]);
    }

    public static function modification(){
        //Si idUtilisateur existe
        if(ConnexionUtilisateur::estConnecte()){
            $idUtilisateur = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            //Recuperation des infos de l'utilisateur dans la BD
            $user = (new UtilisateurRepository())->select($idUtilisateur);
        }else {
            //Sinon crée un utilisateur vide
            $user = new Utilisateur('', '', '', '', '','', '','');
        }
        self::afficheVue('view.php',['pagetitle'=>"VoteIt - Profil/Modification",'cheminVueBody'=>"profil/modification.php", 'user' => $user]);
    }

    public static function error(){
        //Renvoye a la page d'erreur avec le code PC-1
        ControllerErreur::erreurCodeErreur('PC-1');
    }

    //Function to not see
    public static function register(){
        //Si toutes les informations du formulaires ont était inscrite
        if(isset($_REQUEST['identifiant']) AND isset($_REQUEST['mail']) AND isset($_REQUEST['password']) AND isset($_REQUEST['prenom']) AND isset($_REQUEST['nom']) AND isset($_REQUEST['dtnaissance']) AND isset($_REQUEST['conditionandcasuse'])){
            $identifiant = $_REQUEST['identifiant'];
            $mail = $_REQUEST['mail'];
            $password = $_REQUEST['password'];
            $prenom = $_REQUEST['prenom'];
            $nom = $_REQUEST['nom'];
            $dtnaissance = $_REQUEST['dtnaissance'];
            $condition = $_REQUEST['conditionandcasuse'];

            //Si la condition à était check
            if($condition == true){
                //Création de l'utilisateur
                $password = MotDePasse::hacher($password);
                $nonce = MotDePasse::genererChaineAleatoire();
                $user = new Utilisateur($identifiant, $password, $nom, $prenom, $dtnaissance, '1', '', $mail, $nonce, 'user');
                //Import des infos dans la BD
                (new UtilisateurRepository())->create($user);

                VerificationEmail::envoiEmailValidation($user);

                header("Location: frontController.php?controller=profil&action=home");
                exit();
            }else {
                //Retourne vers la page d'inscription
                MessageFlash::ajouter("warning", "Vous devez accepter les conditions d'utilisation");
                ControllerProfil::inscription();
            }
        }else {
            //Retourne vers la page d'inscription
            MessageFlash::ajouter("warning", "Tous les champs n'ont pas été remplis");
            ControllerProfil::inscription();
        }
    }
    public static function connected(){
        //Si les informations du formulaire sont remplies
        if(isset($_REQUEST['identifiant']) AND isset($_REQUEST['password'])){
            $identifiant = $_REQUEST['identifiant'];
            $password = $_REQUEST['password'];

            //Si les informations de la BD correspondent
            $user = (new UtilisateurRepository())->select($identifiant);
            if(MotDePasse::verifier($password, $user->getMotDePasse())){
                ConnexionUtilisateur::connecter($identifiant);
                
                MessageFlash::ajouter("success", "Connexion réussie à votre profil");
                header("Location: frontController.php?controller=profil&action=home");
                exit();
            }else {
                ControllerErreur::erreurCodeErreur('PC-4');
            }
        }else {
            ControllerErreur::erreurCodeErreur('PC-2');
        }
    }

    public static function edit(){
        //Si toutes les informations du formulaires sont remplies
        if(isset($_REQUEST['identifiant']) AND isset($_REQUEST['mail']) AND isset($_REQUEST['password']) AND isset($_REQUEST['prenom']) AND isset($_REQUEST['nom']) AND isset($_REQUEST['dtnaissance'])){
            $identifiant = $_REQUEST['identifiant'];
            $mail = $_REQUEST['mail'];
            $password = $_REQUEST['password'];
            $prenom = $_REQUEST['prenom'];
            $nom = $_REQUEST['nom'];
            $dtnaissance = $_REQUEST['dtnaissance'];


            //Récuperation de l'utilisateur actuelle dans la BD
            $userBefore = (new UtilisateurRepository())->select($identifiant);
            $mailAValider = "";
            $nonce = "";
            if(strcmp($mail, $userBefore->getMail()) != 0){
                $mailAValider = $mail;
                $mail = "";
                $nonce = MotDePasse::genererChaineAleatoire();
            }
            $iconeLink = $userBefore->getIconeLink();
            $grade = $userBefore->getGrade();

            //Création d'un nouvelle utilisateur avec les nouvelles informations
            $userEdit = new Utilisateur($identifiant, $password, $nom, $prenom, $dtnaissance, $iconeLink, $mail, $mailAValider, $nonce, $grade);
            //Mise à jour de l'utilisateur
            (new UtilisateurRepository())->update($userEdit);

            VerificationEmail::envoiEmailValidation($userEdit);
            //Redirection vers la page d'accueil
            header("Location: frontController.php?controller=profil&action=home");
            exit();
        }else {
            //Si il y a au moins l'identifiant
            if(isset($_REQUEST['identifiant'])){
                //Redirection vers la page de modification
                header("Location: frontController.php?controller=profil&action=modification&idUtilisateur=".$_REQUEST['identifiant']);
                exit();
            }else{
                //Renvoye vers la page d'erreur avec le code PC-2
                ControllerErreur::erreurCodeErreur('PC-2');
            }
        }
    }
    public static function deconnection(){
        if(ConnexionUtilisateur::estConnecte() == true){
            ConnexionUtilisateur::deconnecter();
            header("Location: frontController.php");
            exit();
        }else {
            LibMessageFlash::ajouter("warning", "Vous devez être connecté pour pouvoir faire ceci");
            header("Location: frontController.php");
            exit();
        }
    }

    public static function validerEmail(){
        if(isset($_REQUEST['login']) AND isset($_REQUEST['nonce'])){
            if(VerificationEmail::traiterEmailValidation($_REQUEST['login'], $_REQUEST['nonce']) == true){
                MessageFlash::ajouter("success", "Validation de l'email.");
                header("Location: frontController.php?controller=profil&action=home");
            }else {
                MessageFlash::ajouter("warning", "Login ou Nonce invalide");
                header("Location: frontController.php?controller=profil&action=home");
            }
        }else {
            MessageFlash::ajouter("warning", "Ajoutez un login et un nonce.");
            header("Location: frontController.php");
            exit();
        }
    }
}
