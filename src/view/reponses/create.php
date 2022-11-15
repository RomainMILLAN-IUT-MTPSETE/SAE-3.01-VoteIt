<link rel="stylesheet" href="css/Reponses/reponses-formulaire.css">
<form class="reponses-formulaire--container" action="frontController.php?controller=reponses&action=created" method="post">
    <h2>Crée une réponse</h2>
    <div>
        <label for="titreQuestion">Identifiant Question</label>
        <input type="number" name="idQuestion" id="idQuestion" placeholder="11"/>
    </div>
    <div>
        <label for="autheur">Auteur</label>
        <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10"/>
    </div>
    <hr width="200">
    <div class="section-text--container">
        <?php
        $i=1;
        foreach($sections as $section){
            ?>
            <div class="section-container">
                <label id="title-section-container" for="titreSection">Section n°<?php echo$i; ?></label>
                <p><?php echo($section->getTitreSection()); ?></p>
                <p><?php echo($section->getDescriptionSection()); ?></p>
                <input type="text" name="texteSection<?php echo($section->getIdSection()); ?>" id="texteSection<?php echo($section->getIdSection()) ?>">
            </div>
            <?php
            $i++;
        }
        ?>
    </div>
    <input type="hidden" name="controller" value="questions">
    <input type="hidden" name="action" value="created">
    <input type="submit" value="Poser la question">
</form>