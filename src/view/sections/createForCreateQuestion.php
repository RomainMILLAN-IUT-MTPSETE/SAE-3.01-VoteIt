<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Sections/sections-formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=sections&action=created" method="post">
    <div class="formulaire-template">
        <h2 class="title">Création des sections</h2>
        <?php
        for ($i=1; $i<$nbSections+1; $i++){
            ?>
            <div class="section-create--container">
                <label class="section-create-label" for="autheur" required>Section n°<?php echo(htmlspecialchars($i)) ?></label>
                <input class="section-create-input" type="text" name="section<?php echo(htmlspecialchars($i)) ?>" id="section<?php echo(htmlspecialchars($i)) ?>" placeholder="Titre de la section <?php echo(htmlspecialchars($i)) ?>" required/>
                <input class="section-create-input" type="text" name="description<?php echo(htmlspecialchars($i)) ?>" id="description<?php echo(htmlspecialchars($i)) ?>" placeholder="Description de la section <?php echo(htmlspecialchars($i)) ?>" required/>
            </div>
            <?php
        }
        ?>

        <div>
            <input type="hidden" name="controller" value="sections">
            <input type="hidden" name="action" value="created">
            <input type="hidden" name="nbSections" value="<?php echo(htmlspecialchars($nbSections)) ?>">
            <input type="hidden" name="idQuestion" value="<?php echo(htmlspecialchars($idQuestion)) ?>">
            <input type="submit" value="Créer les sections">
        </div>
    </div>
</form>