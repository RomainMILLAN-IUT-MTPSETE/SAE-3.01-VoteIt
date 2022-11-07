<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="<?php echo('css/app.css') ?>"/>
    <link rel="stylesheet" href="<?php echo('css/layout.css') ?>"/>
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
        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>

    <footer>
    </footer>
</body>
</html>