<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="<?php echo('css/app.css') ?>"/>
    <link rel="shortcut icon" href="assets/logo/logoSansOmbre.png" type="image/x-icon">
</head>
<body class="layout">
    <header>
        <img src="assets/menu/menu.png" alt="Icone de menu"/>
        <p>VoteIt<span class="colored">.</span></p>
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