<link rel="stylesheet" href="css/Erreur/erreur-home.css">
<section class="erreur-home--container">
    <h2>Erreur</h2>
    <p class="text">Une erreur est survenue</p>
    <?php
    if(isset($codeErreur)){
        ?><p class="code-erreur">Code d'erreur: <a href="frontController.php?controller=erreur&action=seeCode"><?php echo($codeErreur) ?></a></p><?php
    }
    ?>
</section>