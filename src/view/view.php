<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="<?php echo('css/app.css') ?>"/>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="frontController.php?action=readAll">Accueil</a></li>
            <li><a href="frontController.php?controller=utilisateur&action=readAll">Utilisateur</a></li>
            <li><a href="frontController.php?controller=trajet&action=readAll">Trajet</a></li>
        </ul>
    </nav>
</header>
<main>
    <?php
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
    <p>Site de covoiturage de ...</p>
</footer>
</body>
</html>