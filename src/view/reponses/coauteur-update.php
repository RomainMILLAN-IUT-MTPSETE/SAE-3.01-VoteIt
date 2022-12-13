<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=reponses&action=updatedcoauteur" method="post">
    <div class="formulaire-template">
        <h2 class="title">Modification de la réponse</h2>
        <div class="section-text--container">
            <?php
            $i=1;
            foreach($reponseSection as $reponseSection){
                $section = (new \App\VoteIt\Model\Repository\SectionRepository())->selectFromIdSection($reponseSection->getIdSection());
                ?>
                <hr width="200">
                <div class="section-container">
                    <label id="title-section-container" for="titreSection">Section n°<?php echo(htmlspecialchars($i)); ?></label>
                    <p><?php echo(htmlspecialchars($section->getTitreSection())); ?>: <?php echo(htmlspecialchars($section->getDescriptionSection())) ?></p>
                    <input type="hidden" name="idSection<?php echo(htmlspecialchars($i)); ?>" value="<?php echo(htmlspecialchars($section->getIdSection())); ?>" required>
                    <textarea name="texteSection<?php echo(htmlspecialchars($i)); ?>" required><?php echo(htmlspecialchars($reponseSection->getTexteSection())) ?></textarea>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <div>
            <input type="hidden" name="idQuestion" value="<?php echo(htmlspecialchars($reponse->getIdQuestion())); ?>">
            <input type="hidden" name="nbSection" value="<?php echo(htmlspecialchars($i-1)); ?>">

            <input type="number" name="idReponse" id="idReponse" placeholder="11" value="<?php echo(htmlspecialchars($reponse->getIdReponse())); ?>" readonly hidden required/>

            <input type="submit" value="Modifier la question">
        </div>
    </div>
</form>