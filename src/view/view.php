<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="<?php echo('css/app.css') ?>"/>
    <link rel="stylesheet" href="<?php echo('css/layout.css') ?>"/>
    <link rel="stylesheet" href="<?php echo('css/messagesFlash.css') ?>"/>
    <link rel="shortcut icon" href="assets/logo/logoSansOmbre.png" type="image/x-icon">
</head>
<body class="layout">
    <?php
    if(isset($_GET['menu']) AND $_GET['menu']=="on"){
        require_once 'menu.php';
    }
    ?>
    <header>
        <section class="header-mobile">
            <a href="<?php echo('http://' . $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'] . '&menu=on' ?>"><img src="assets/menu/menu.png" alt="Icone de menu"/></a>
            <p>VoteIt<span class="colored">.</span></p>
        </section>
        <section class="header-desktop">
            <div>
                <a href="frontController.php"><img src="assets/logo/logoSansOmbre.png" alt="Logo du site internet"></a>
                <form action="frontController.php" method="get"><input type="hidden" name="controller" value="questions"><input type="hidden" name="action" value="recherche"><input type="text" name="search" id="search" placeholder="Recherche"></form>
            </div>
            <div>
                <nav>
                    <a href="frontController.php?controller=home&action=home"><p>Accueil</p></a>
                    <a href="frontController.php?controller=questions&action=home"><p>Questions</p></a>
                    <a href="frontController.php?controller=profil&action=home"><p>Profil</p></a>
                </nav>
                <a href="#"><img src="assets/logo/logoAvecOmbre.png" alt="Icone du profile de la personne"></a>
            </div>
        </section>
    </header>

    <main>
        <?php
        use \App\VoteIt\Lib\MessageFlash;
        $array = MessageFlash::lireTousMessages();
        while($element = current($array)) {
            ?>
            <div class="alert alert-<?php echo key($array)  ?>">
                <a href="<?php echo('http://' . $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'] ?>"><img src="assets/messageFlash/croix.png" alt="Icone Croix"></a>
                <p><?php echo($array[key($array)]); ?></p>
            </div>
            <?php
            next($array);
        }



        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>

    <footer>



            <div class="contenue-footer">

                <div class="blo footer-contact">
                <span style="display: flex; align-items: center;gap: 10px"><img src="assets/logo/logoSansOmbre.png" class="logofooter">    <h2>VoteIt<span class="colored">.</span></h2>   </span>
                    <p id="herault">34200, Hérault,Sète</p>
                    <span class="email-button"> <h2>Contactez-nous!</h2> <button class="bout-email">Envoyer un email</button> </span>
                    <p id="droitreserv">© 2022 VoteIt. Tous droits réservés. </p>

                </div>


                <div class="div blo footer-acceuil">
                    <h3>Acceuil</h3>
                    <p >Qui somme-nous? </p>
                    <p href="#">Le projet </p>
                </div>

                <div class="div blo footer-question">
                    <h3>Questions</h3>
                    <p href="#">Consulter les questions</p>
                    <p>Proposer une question </p>

                </div>

                <div class="div blo footer-profil">
                    <h3>Profil</h3>
                    <p>Consulter mon profil </p>
                    <p>S'inscrire</p>
                    <p>Se connecter</p>

                </div>

                <div class="div blo footer-legal">
                    <h3>Légal</h3>
                    <p>Condition générale d'utilisation </p>
                </div>

            </div>

    </footer>
</body>
</html>