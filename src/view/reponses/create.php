<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=reponses&action=created" method="post">
    <div class="formulaire-template">
        <h2 class="title">Crée une réponse</h2>
        <div class="div-form-normal">
            <label for="idQuestion">Identifiant Question</label>
            <input type="number" name="idQuestion" id="idQuestion" placeholder="11" value="<?php echo($_GET['idQuestion']); ?>" readonly required/>
        </div>
        <div class="div-form-normal">
            <label for="autheur">Auteur</label>
            <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10" required/>
        </div>
        <div class="div-form-normal">
            <label for="titreReponse">Titre de la réponse</label>
            <input type="text" name="titreReponse" id="titreReponse" placeholder="Titre de la réponse" required>
        </div>
        <div class="section-text--container">
            <?php
            $i=1;
            foreach($sections as $section){
                ?>
                <hr width="200">
                <div class="section-container">
                    <label id="title-section-container" for="titreSection">Section n°<?php echo$i; ?></label>
                    <p><?php echo($section->getTitreSection()); ?>: <?php echo($section->getDescriptionSection()) ?></p>
                    <input type="hidden" name="idSection<?php echo($i); ?>" value="<?php echo($section->getIdSection()); ?>" required>
                    <textarea name="texteSection<?php echo($i); ?>" required></textarea>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <div>
            <input type="hidden" name="nbSection" value="<?php echo($i-1); ?>">
            <input type="submit" value="Poser la question">
        </div>
    </div>
</form>