<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Sections/sections-formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=sections&action=created" method="post">
    <div class="formulaire-template">
        <h2 class="title">Crée les sections</h2>
        <?php
        for ($i=1; $i<$nbSections+1; $i++){
            ?>
            <div class="section-create--container">
                <label class="section-create-label" for="autheur" required>Section n°<?php echo $i ?></label>
                <input class="section-create-input" type="text" name="section<?php echo $i ?>" id="section<?php echo $i ?>" placeholder="Titre de la section <?php echo $i ?>" required/>
                <input class="section-create-input" type="text" name="description<?php echo $i ?>" id="description<?php echo $i ?>" placeholder="Description de la section <?php echo $i ?>" required/>
            </div>
            <?php
        }
        ?>

        <div>
            <input type="hidden" name="controller" value="sections">
            <input type="hidden" name="action" value="created">
            <input type="hidden" name="nbSections" value="<?php echo $nbSections ?>">
            <input type="hidden" name="idQuestion" value="<?php echo $idQuestion ?>">
            <input type="submit" value="Créer les sections">
        </div>
    </div>
</form>