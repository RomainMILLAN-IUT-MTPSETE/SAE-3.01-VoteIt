<?php
use App\VoteIt\Lib\ConnexionUtilisateur;
use App\VoteIt\Lib\MessageFlash;
use App\VoteIt\Model\Repository\UtilisateurRepository;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo(htmlspecialchars($pagetitle));?></title>
    <link rel="stylesheet" href="<?php echo('css/app.css') ?>"/>
    <link rel="stylesheet" href="<?php echo('css/layout.css') ?>"/>
    <link rel="stylesheet" href="<?php echo('css/messagesFlash.css') ?>"/>
    
    <!--Icone on title page-->
    <link rel="shortcut icon" href="assets/logo/logoSansOmbre.png" type="image/x-icon">
</head>
<body class="layout">
    <?php
    if(isset($_GET['menu']) AND $_GET['menu']=="on"){
        //If $_GET['menu'] is "on" open the mobile menu
        require_once 'menu.php';
    }
    ?>
    <header>
        <section class="header-mobile">
            <!--HEADER for mobile-->
            <a href="<?php echo('http://' . $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'] . '&menu=on' ?>"><img src="assets/menu/menu.png" alt="Icone de menu"/></a>
            <p>VoteIt<span class="colored">.</span></p>
        </section>
        <section class="header-desktop">
            <!--HEADER for desktop-->
            <div>
                <a href="frontController.php"><img src="assets/logo/logoSansOmbre.png" alt="Logo du site internet"></a>
                <form action="frontController.php" method="get"><input type="hidden" name="controller" value="questions"><input type="hidden" name="action" value="recherche"><input type="text" name="search" id="search" placeholder="Recherche"></form>
            </div>
            <div>
                <nav>
                    <a href="frontController.php?controller=home&action=home"><p>Accueil</p></a>
                    <a href="frontController.php?controller=questions&action=home"><p>Questions</p></a>
                    <a href="frontController.php?controller=profil&action=home"><p>Profil</p></a>
                    <?php if(ConnexionUtilisateur::estConnecte()){ if(strcmp((new UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getGrade(), "Administrateur") == 0) { ?> <a href="frontController.php?controller=dashboard&action=dashboard"><p>Dashboard</p></a> <?php } } ?>
                </nav>
                <a href="frontController.php?controller=profil&action=home"><img src="assets/logo/logoAvecOmbre.png" alt="Icone du profile de la personne"></a>
            </div>
        </section>
    </header>


    <main>
        <?php
        //MESSAGES FLASH

        $array = MessageFlash::lireTousMessages();
        while($element = current($array)) {
            ?>
            <div class="alert alert-<?php echo(htmlspecialchars(key($array)))  ?>">
                <a href="<?php echo('http://' . $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'] ?>"><img src="assets/messageFlash/croix.png" alt="Icone Croix"></a>
                <p><?php echo($array[key($array)]); ?></p>
            </div>
            <?php
            next($array);
        }

        //BODY
        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>


    <footer>
            <div class="contenue-footer">
                <div class="blo footer-contact">
                <span class="logo-and-title"><img src="assets/logo/logoSansOmbre.png" class="logofooter">    <h2>VoteIt<span class="colored">.</span></h2>   </span>
                    <p id="herault">34200, Hérault,Sète</p>
                    <span class="email-button"> <h2>Contactez-nous!</h2> <a href="mailto:contact@voteit.ml"><button class="bout-email">Envoyer un email</button></a> </span>
                    <p id="droitreserv">© 2023 VoteIt. Tous droits réservés.</p>
                </div>

                <div class="div blo footer-acceuil">
                    <h3>Accueil</h3>
                    <a href="frontController.php?controller=home&action=home#quisommesnous"><p>Qui sommes-nous?</p></a>
                    <a href="frontController.php?controller=home&action=home#leprojet"><p>Le projet</p></a>
                </div>
                <div class="div blo footer-question">
                    <h3>Questions</h3>
                    <a href="frontController.php?controller=questions&action=home"><p>Consulter les questions</p></a>
                    <a href="frontController.php?controller=questions&action=create"><p>Proposer une question</p></a>

                </div>
                <div class="div blo footer-profil">
                    <h3>Profil</h3>
                    <a href="frontController.php?controller=profil&action=home"><p>Consulter mon profil</p></a>
                    <a href="frontController.php?controller=profil&action=inscription"><p>S'inscrire</p></a>
                    <a href="frontController.php?controller=profil&action=connection"><p>Se connecter</p></a>

                </div>
                <div class="div blo footer-legal">
                    <h3>Légal</h3>
                    <a href="frontController.php?controller=home&action=cgu"><p>Conditions générales d'utilisation</p></a>
                </div>
            </div>
    </footer>
</body>
</html>