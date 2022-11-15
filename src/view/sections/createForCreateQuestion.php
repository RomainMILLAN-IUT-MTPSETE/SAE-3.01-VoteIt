<link rel="stylesheet" href="css/Sections/sections-formulaire.css">
<form class="questions-formulaire--container" action="frontController.php?controller=sections&action=created" method="post">
    <h2>Crée les sections</h2>
    <?php
    for ($i=1; $i<$nbSections+1; $i++){
        ?>
        <div>
            <label for="autheur">Section n°<?php echo $i ?></label>
            <input type="text" name="section<?php echo $i ?>" id="section<?php echo $i ?>" placeholder="Titre de la section <?php echo $i ?>"/>
            <input type="text" name="description<?php echo $i ?>" id="description<?php echo $i ?>" placeholder="Description de la section <?php echo $i ?>"/>
        </div>
        <?php
    }
    ?>

    <input type="hidden" name="controller" value="sections">
    <input type="hidden" name="action" value="created">
    <input type="hidden" name="nbSections" value="<?php echo $nbSections ?>">
    <input type="hidden" name="idQuestion" value="<?php echo $idQuestion ?>">
    <input type="submit" value="Créer les sections">
</form>