<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=reponses&action=created" method="post">
    <div class="formulaire-template">
        <h2 class="title">Créer une réponse</h2>
        <div class="div-form-normal">
            <label for="idQuestion">Identifiant Question</label>
            <input type="number" name="idQuestion" id="idQuestion" placeholder="11" value="<?php echo(htmlspecialchars($_GET['idQuestion'])); ?>" readonly required/>
        </div>
        <div class="div-form-normal">
            <label for="autheur">Auteur</label>
            <input type="text" name="autheur" id="autheur" value="<?php echo(\App\VoteIt\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte()) ?>" placeholder="JohnDoe10" required/>
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
                    <label id="title-section-container" for="titreSection">Section n°<?php echo(htmlspecialchars($i)); ?></label>
                    <p><?php echo(htmlspecialchars($section->getTitreSection())); ?>: <?php echo(htmlspecialchars($section->getDescriptionSection())) ?></p>
                    <input type="hidden" name="idSection<?php echo(htmlspecialchars($i)); ?>" value="<?php echo(htmlspecialchars($section->getIdSection())); ?>" required>
                    <textarea name="texteSection<?php echo(htmlspecialchars($i)); ?>" required></textarea>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <div>
            <input type="hidden" name="nbSection" value="<?php echo(htmlspecialchars($i-1)); ?>">
            <input type="submit" value="Poser la question">
        </div>
    </div>
</form>