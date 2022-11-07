<link rel="stylesheet" href="css/Erreur/erreur-home.css">
<section class="erreur-home--container">
    <h2>Erreur</h2>
    <p class="text">Une erreur est survenue</p>
    <?php
    if(isset($codeErreur)){
        ?><p class="code-erreur">Code d'erreur: <?php echo($codeErreur) ?></p><?php
    }
    ?>
</section>