<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=reponses&action=updated" method="post">
    <div class="formulaire-template">
        <h2 class="title">Modifier une réponse</h2>
        <div class="div-form-normal">
            <label for="idReponse">Identifiant Réponse</label>
            <input type="number" name="idReponse" id="idReponse" placeholder="11" value="<?php echo($_GET['idReponse']); ?>" readonly required/>
        </div>
        <div class="div-form-normal">
            <label for="autheur">Auteur</label>
            <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10" value="<?php echo($reponse->getAutheurId()) ?>" required/>
        </div>
        <div class="div-form-normal">
            <label for="titreReponse">Titre de la réponse</label>
            <input type="text" name="titreReponse" id="titreReponse" placeholder="Titre de la réponse" value="<?php echo($reponse->getTitreReponse()) ?>" required>
        </div>
        <div class="section-text--container">
            <?php
            $i=1;
            foreach($reponseSection as $reponseSection){
                $section = (new \App\VoteIt\Model\Repository\SectionRepository())->selectFromIdSection($reponseSection->getIdSection());
                ?>
                <hr width="200">
                <div class="section-container">
                    <label id="title-section-container" for="titreSection">Section n°<?php echo$i; ?></label>
                    <p><?php echo($section->getTitreSection()); ?>: <?php echo($section->getDescriptionSection()) ?></p>
                    <input type="hidden" name="idSection<?php echo($i); ?>" value="<?php echo($section->getIdSection()); ?>" required>
                    <textarea name="texteSection<?php echo($i); ?>" required><?php echo($reponseSection->getTexteSection()) ?></textarea>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <div>
            <input type="hidden" name="idQuestion" value="<?php echo($reponse->getIdQuestion()); ?>">
            <input type="hidden" name="nbVote" value="<?php echo($reponse->getNbVote()); ?>">
            <input type="hidden" name="nbSection" value="<?php echo($i-1); ?>">
            <input type="submit" value="Poser la question">
        </div>
    </div>
</form>